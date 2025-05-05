<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\OffreemploiRepository;
use App\Repository\EntretienRepository;
use App\Repository\AssuranceRepository;
use App\Repository\CongeRepository;
use App\Repository\CertificationRepository;
use App\Repository\EmployeeRepository;
use App\Repository\BudgetRepository;
class BackController extends AbstractController
{
    #[Route('/back', name: 'admin_dashboard')]
    public function index(CertificationRepository $certificationRepository,EmployeeRepository $employeeRepository, BudgetRepository $budgetRepository,FormationRepository $formationRepository, OffreemploiRepository $offreemploiRepository, EntretienRepository $entretienRepository, AssuranceRepository $assuranceRepository,CongeRepository $congeRepository, ): Response
    {
        $nombreFormations = $formationRepository->count([]);
        $nombreOffre = $offreemploiRepository->count([]);
        $nombreEntretien = $entretienRepository->count([]);
        $nombreAssurance = $assuranceRepository->count([]);
        $nombreConge = $congeRepository->count([]);
        $nombreCertif = $certificationRepository->count([]);
        $nombreBudget = $budgetRepository->count([]);
        $nombreEmployee = $employeeRepository->count([]);
        return $this->render('back/index.html.twig', [
            'nombreFormations' => $nombreFormations,
            'nombreOffre' => $nombreOffre,
            'nombreEntretien' => $nombreEntretien,
            'nombreAssurance' =>$nombreAssurance,
            'nombreConge' =>$nombreConge,
            'nombreCertif'=>$nombreCertif,
            'nombreBudget'=>$nombreBudget,
            'nombreEmployee'=>$nombreEmployee,

        ]);

    }

}