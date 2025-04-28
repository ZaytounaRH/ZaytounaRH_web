<?php

namespace App\Controller;

use App\Repository\EntretienRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Entretien;
use Doctrine\ORM\EntityManagerInterface;

class ApiEntretienController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Injection de EntityManagerInterface via le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Récupère tous les entretiens sous forme d'événements pour le calendrier
    #[Route('/api/entretiens', name: 'api_entretiens')]
    public function getEntretiens(EntretienRepository $repo): JsonResponse
    {
        $entretiens = $repo->findAll();
        $events = [];

        foreach ($entretiens as $e) {
            $dateEntretien = $e->getDateEntretien();
            $formattedDate = $dateEntretien ? $dateEntretien->format('Y-m-d') : null;

            $heureEntretien = $e->getHeureEntretien();
            if ($heureEntretien instanceof \DateTime) {
                $heureEntretien = $heureEntretien->format('H:i:s');
            }

            $candidat = $e->getCandidat();
            $offre = $e->getOffreemploi(); // 🟢 Corrigé ici

            $events[] = [
                'id' => $e->getIdEntretien(),
                'title' => $e->getTypeEntretien() . ' - ' . $e->getStatut(),
                'start' => $formattedDate . 'T' . $heureEntretien,
                'color' => match ($e->getStatut()) {
                    'EN_COURS' => 'orange',
                    'PLANIFIE' => 'blue',
                    'TERMINE' => 'green',
                    'ANNULE' => 'red',
                    default => 'gray',
                },
                'type' => $e->getTypeEntretien(),
                'statut' => $e->getStatut(),
                'candidat' => $candidat ? [
                    'user_prenom' => $candidat->getUser() ? $candidat->getUser()->getPrenom() : null,
                    'user_nom' => $candidat->getUser() ? $candidat->getUser()->getNom() : null,
                ] : null,
                'offre' => $offre ? [
                    'titre' => $offre->getTitreOffre(),
                ] : null,
            ];
        }

        return new JsonResponse($events);
    }

    // Met à jour la date de début de l'entretien
    #[Route('/update-entretien-date', name: 'update_entretien_date', methods: ['POST'])]
    public function updateEntretienDate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['id']) || !isset($data['start'])) {
            return new JsonResponse(['error' => 'Données manquantes'], 400);
        }

        $id = $data['id'];
        $newStartDate = new \DateTime($data['start']);

        // Utilisation de l'EntityManager injecté pour récupérer l'entretien
        $entretien = $this->entityManager->getRepository(Entretien::class)->find($id);

        if ($entretien) {
            $entretien->setDateDebut($newStartDate); // Mettre à jour la date
            $this->entityManager->flush(); // Enregistrer les changements en base

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false], 400);
    }
}
