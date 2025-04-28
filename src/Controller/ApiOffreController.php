<?php

namespace App\Controller;

use App\Repository\OffreemploiRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Offreemploi;
use Doctrine\ORM\EntityManagerInterface;

class ApiOffreController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/offres', name: 'api_offres')]
    public function getOffres(OffreemploiRepository $repo): JsonResponse
    {
        $offres = $repo->findAll();
        $events = [];

        foreach ($offres as $offre) {
            $datePublication = $offre->getDatePublication();
            $formattedDate = $datePublication ? $datePublication->format('Y-m-d') : null;

            $rh = $offre->getRh();
            $user = $rh ? $rh->getUser() : null;

            $events[] = [
                'id' => $offre->getIdOffre(), // attention: méthode correcte selon ton entité
                'title' => $offre->getTitreOffre(),
                'start' => $formattedDate,
                'description' => $offre->getDescription(),
                'salaire' => $offre->getSalaire(),
                'statut' => $offre->getStatut(),
                'RH' => $rh ? [
                    'user_prenom' => $rh->getUser() ? $rh->getUser()->getPrenom() : null,
                    'user_nom' => $rh->getUser() ? $rh->getUser()->getNom() : null,
                ] : null, 
            ];
        }

        return new JsonResponse($events);
    }

    #[Route('/update-offre-date', name: 'update_offre_date', methods: ['POST'])]
    public function updateOffreDate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['id']) || !isset($data['start'])) {
            return new JsonResponse(['error' => 'Données manquantes'], 400);
        }

        $id = $data['id'];
        $newStartDate = new \DateTime($data['start']);

        $offre = $this->entityManager->getRepository(Offreemploi::class)->find($id);

        if ($offre) {
            $offre->setDatePublication($newStartDate); // ici on met à jour "datePublication"
            $this->entityManager->flush();

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false], 400);
    }
}
