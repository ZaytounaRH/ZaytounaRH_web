<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Repository\RhRepository;

use App\Entity\Employee;
use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/presence')]
final class PresenceController extends AbstractController
{
    #[Route('/employees', name: 'app_presence_employees', methods: ['GET'])]
    public function listEmployees(EmployeeRepository $employeeRepository): Response
    {
        $employees = $employeeRepository->findAll();

        return $this->render('presence/employees.html.twig', [
            'employees' => $employees,
        ]);
    }


    #[Route('/presenceback', name: 'app_presence_admin_index', methods: ['GET'])]
public function adminIndex(PresenceRepository $presenceRepository): Response
{
    return $this->render('presence/indexback.html.twig', [
        'presences' => $presenceRepository->findAll(),
    ]);
}

    

    #[Route('/employee/{id}', name: 'app_presence_by_employee', methods: ['GET'])]
    public function showPresences(int $id, PresenceRepository $presenceRepository): Response
    {
        $presences = $presenceRepository->findBy(['employee' => $id]);

        return $this->render('presence/show_by_employee.html.twig', [
            'presences' => $presences,
            'employee_id' => $id,
        ]);
    }

    #[Route('/', name: 'app_presence_index', methods: ['GET'])]
    public function index(PresenceRepository $presenceRepository): Response
    {
        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository->findAll(),
        ]);
    }
    

    #[Route('/new', name: 'app_presence_new', methods: ['GET', 'POST'])]
public function new(
    Request $request,
    EntityManagerInterface $entityManager,
    RhRepository $rhRepository
): Response {
    $presence = new Presence();

    $now = new \DateTimeImmutable();
    $presence->setDate($now);
    $presence->setHeureArrive($now);

    // ✅ Récupérer un objet Rh depuis RhRepository
    $rh = $rhRepository->findOneBy([]); // si tu n’as qu’un seul RH
    $presence->setRh($rh); // maintenant c’est du bon type ✔️

    $form = $this->createForm(PresenceType::class, $presence);
    $form->remove('date');
    $form->remove('heureArrive');
    $form->remove('rh');

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($presence);
        $entityManager->flush();

        return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('presence/new.html.twig', [
        'presence' => $presence,
        'form' => $form,
    ]);
}



/*#[Route('/checkin/{id}', name: 'app_presence_checkin')]
public function checkIn(int $id, EntityManagerInterface $entityManager, EmployeeRepository $employeeRepository): Response
{
    $employee = $employeeRepository->find($id);
    if (!$employee) {
        throw $this->createNotFoundException('Employee not found');
    }

    $now = new \DateTimeImmutable();

    $presence = new Presence();
    $presence->setDate($now);
    $presence->setHeureArrive($now);
    $presence->setEmployee($employee);

    $entityManager->persist($presence);
    $entityManager->flush();

    $this->addFlash('success', 'Présence enregistrée avec succès.');

    return $this->redirectToRoute('app_presence_by_employee', ['id' => $id]);
}*/




#[Route('/{id_presence}', name: 'app_presence_show', methods: ['GET'])]
public function show(Presence $presence): Response
{
    $employeeId = $presence->getEmployee()?->getEmployeeId(); // ⚠️ ou getId() selon ton entité

    return $this->render('presence/show.html.twig', [
        'presence' => $presence,
        'employee_id' => $employeeId, // ✅ Cette ligne est essentielle pour éviter l’erreur
    ]);
}


    

    #[Route('/{id_presence}/edit', name: 'app_presence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presence $presence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('presence/edit.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('/{id_presence}', name: 'app_presence_delete', methods: ['POST'])]
    public function delete(Request $request, Presence $presence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $presence->getId_presence(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($presence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/checkin/{id}', name: 'app_presence_checkin')]
    #[Route('/checkin/{id}', name: 'app_presence_checkin')]
    public function checkIn(
        int $id,
        EntityManagerInterface $entityManager,
        EmployeeRepository $employeeRepository,
        UserRepository $userRepository
    ): Response {
        $employee = $employeeRepository->find($id);
        if (!$employee) {
            throw $this->createNotFoundException('Employé non trouvé');
        }
    
        $rh = $userRepository->findOneBy(['user_type' => 'RH']);
        if (!$rh) {
            throw $this->createNotFoundException('RH non trouvé');
        }
    
        $now = new \DateTimeImmutable();
    
        $presence = new Presence();
        $presence->setDate($now);
        $presence->setHeureArrive($now);
        $presence->setEmployee($employee);
        $presence->setRh($rh);
    
        $entityManager->persist($presence);
        $entityManager->flush();
    
        $this->addFlash('success', 'Arrivée enregistrée avec succès.');
        return $this->redirectToRoute('app_presence_by_employee', ['id' => $id]);
    }
    
    
    #[Route('/checkout/{id}', name: 'app_presence_checkout')]
    public function checkOut(
        int $id,
        PresenceRepository $presenceRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $today = new \DateTimeImmutable('today');
    
        $presence = $presenceRepository->findOneBy([
            'employee' => $id,
            'date' => $today
        ]);
    
        if (!$presence) {
            throw $this->createNotFoundException("Aucune présence trouvée pour aujourd’hui.");
        }
    
        $presence->setHeureDepart(new \DateTime());
        $entityManager->flush();
    
        $this->addFlash('success', 'Départ enregistré avec succès.');
        return $this->redirectToRoute('app_presence_by_employee', ['id' => $id]);
    }

    #[Route('/edit-depart', name: 'app_presence_edit_depart')]
    public function editDepart(
        int $id,
        PresenceRepository $presenceRepository,
        EmployeeRepository $employeeRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $employee = $employeeRepository->find($id);
        if (!$employee) {
            $this->addFlash('danger', 'Employé introuvable.');
            return $this->redirectToRoute('app_presence_index');
        }
    
        $today = new \DateTimeImmutable('today');
        $presence = $presenceRepository->findOneBy([
            'employee' => $employee,
            'date' => $today,
        ]);
    
        if (!$presence) {
            $this->addFlash('danger', "Aucune arrivée enregistrée aujourd’hui.");
            return $this->redirectToRoute('app_presence_index');
        }
    
        $presence->setHeureDepart(new \DateTime());
        $entityManager->flush();
    
        $this->addFlash('success', 'Départ enregistré avec succès.');
        return $this->redirectToRoute('app_presence_index');
    }
    

    

    
    
}