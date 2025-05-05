<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\EmployeeRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/formation')]
final class FormationController extends AbstractController
{
    #[Route(name: 'app_formation_index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    #[Route('/certifications', name: 'app_formation_certif_index', methods: ['GET'])]
    public function indexCertif(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/indexCertif.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{idFormation}', name: 'app_formation_show', methods: ['GET'])]
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            
        ]);
    }
    #[Route('/{idFormation}/certificat', name: 'app_formation_certif_show', methods: ['GET'])]
    public function showCertif(Formation $formation): Response
    {
        return $this->render('formation/showCertif.html.twig', [
            'formation' => $formation,
            'certifications' => $formation->getCertifications(),
        ]);
    }
    #[Route('/{idFormation}/edit', name: 'app_formation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{idFormation}', name: 'app_formation_delete', methods: ['POST'])]
    public function delete(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getIdFormation(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/formation/employe', name: 'app_formation_par_employe')]
    public function formationsParEmploye(Request $request, EmployeeRepository $employeeRepo): Response
    {
        $employeeId = $request->query->get('employee_id');
    
        $employees = $employeeRepo->findAll();
        $formations = [];
    
        if ($employeeId) {
            $employee = $employeeRepo->find($employeeId);
            if ($employee) {
                $formations = $employee->getFormations();
            }
        }
    
        return $this->render('formation/formations_par_employe.html.twig', [
            'employees' => $employees,
            'formations' => $formations,
            'selectedEmployeeId' => $employeeId
        ]);
    }
    
}
