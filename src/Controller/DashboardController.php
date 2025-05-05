<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Depense;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
final class DashboardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        // Récupérer les budgets et leurs dépenses associées
        $budgets = $this->entityManager->getRepository(Budget::class)->findAll();

        $dashboardData = [];

        foreach ($budgets as $budget) {
            $depenses = $budget->getDepenses();
            $totalDepenses = 0;

            foreach ($depenses as $depense) {
                $totalDepenses += $depense->getMontant(); // Calculer le total des dépenses pour chaque budget
            }

            $dashboardData[] = [
                'budget' => $budget,
                'totalDepenses' => $totalDepenses,
                'montantAlloue' => $budget->getMontantAlloue(),
                'reste' => $budget->getMontantAlloue() - $totalDepenses, // Calculer le reste à dépenser
            ];
        }

        // Rendre le fichier Twig dédié
        return $this->render('dashboard/index.html.twig', [
            'dashboardData' => $dashboardData,
        ]);
    }
}
