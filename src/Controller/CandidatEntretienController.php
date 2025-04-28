<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Form\EntretienCandidatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Offreemploi;

class CandidatEntretienController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/entretien/candidat/new/{idOffre}', name: 'app_candidat_entretien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $idOffre): Response
    {
        // Récupérer l'offre d'emploi par son ID
        $offreemploi = $entityManager->getRepository(Offreemploi::class)->find($idOffre);

        if (!$offreemploi) {
            throw $this->createNotFoundException('Offre d\'emploi non trouvée');
        }

        // Créer un nouvel objet Entretien
        $entretien = new Entretien();
        $entretien->setOffreemploi($offreemploi);  // Associer automatiquement l'offre d'emploi

        // Créer le formulaire pour l'entretien
        $form = $this->createForm(EntretienCandidatType::class, $entretien);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $entretien->getStatut()) {
                $entretien->setStatut('EN_COURS'); // Mettre par défaut en cours si statut non défini
            }

            // Si la date n'est pas définie, on peut lui donner une valeur par défaut (par exemple la date d'aujourd'hui)
            if (null === $entretien->getDateEntretien()) {
                $entretien->setDateEntretien(new \DateTime()); // Valeur par défaut : aujourd'hui
            }

            $entityManager->persist($entretien);
            $entityManager->flush();

            // Redirection vers la page "merci"
            return $this->redirectToRoute('app_entretien_merci', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/newcandidat.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }
}
