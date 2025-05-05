<?php

namespace App\Controller;
<<<<<<< HEAD
<<<<<<< HEAD

use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
=======
use App\Repository\UserRepository;
use App\Repository\RhRepository;

=======
use App\Repository\UserRepository;
use App\Repository\RhRepository;
use App\Repository\CongeRepository;
>>>>>>> origin/asma_gestion_presence
use App\Entity\Employee;
use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
use App\Repository\EmployeeRepository;
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
<<<<<<< HEAD
=======
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


>>>>>>> origin/asma_gestion_presence

#[Route('/presence')]
final class PresenceController extends AbstractController
{
<<<<<<< HEAD
<<<<<<< HEAD
    #[Route(name: 'app_presence_index', methods: ['GET'])]
=======
=======

    #[Route('/qrcode', name: 'app_presence_qrcode')]
public function qrCode(BuilderInterface $builderInterface, PresenceRepository $presenceRepository): Response
{
    // Récupérer les présences d'aujourd'hui
    $today = new \DateTimeImmutable('today');
    $presences = $presenceRepository->findBy(['date' => $today]);

    // Construire un texte à encoder dans le QR Code
    $presenceData = "Présences du jour:\n";

foreach ($presences as $presence) {
    $employe = $presence->getEmployee();
    if ($employe && $employe->getUser()) {
        $nom = $employe->getUser()->getNom();
        $prenom = $employe->getUser()->getPrenom();
        $heureArrivee = $presence->getHeureArrive();
        $heureFormatted = $heureArrivee ? $heureArrivee->format('H:i') : 'Non défini';
        
        $presenceData .= "- $nom $prenom (Arrivé à: $heureFormatted)\n";
    }
}



    // Créer le QR code avec ce texte
    $qrResult = $builderInterface
        ->data($presenceData)
        ->size(300)
        ->margin(10)
        ->build();

    // Obtenir l'image du QR code
    $qrImage = $qrResult->getDataUri(); 

    // Afficher dans le template
    return $this->render('presence/qrcode.html.twig', [
        'qrImage' => $qrImage,
        'link' => null,  // plus besoin du lien
    ]);
}

    
    #[Route('/stats', name: 'app_presence_stats', methods: ['GET'])]
    public function stats(
        PresenceRepository $presenceRepository,
        CongeRepository $congeRepository
    ): Response {
        // 📅 Année actuelle
        $year = (new \DateTimeImmutable())->format('Y');
    
        // ✅ 1. Taux de présence par mois (formaté pour les graphs)
        $presenceStats = $presenceRepository->countPresencesPerMonth($year);
    
        // ✅ 2. Nombre total de retards enregistrés
        $totalRetards = $presenceRepository->countTotalRetards();
    
        // ✅ 3. Nombre total de jours de congés posés cette année
        $totalConges = $congeRepository->countTotalConges($year);
    
        // ✅ 4. Moyenne d'heures travaillées par jour
        $averageHoursPerDay = $presenceRepository->averageWorkedHoursPerDay();
    
        return $this->render('presence/stats.html.twig', [
            'presenceStats' => $presenceStats,
            'totalRetards' => $totalRetards,
            'totalConges' => $totalConges,
            'averageHoursPerDay' => $averageHoursPerDay,
        ]);
    }

>>>>>>> origin/asma_gestion_presence
    #[Route('/employees', name: 'app_presence_employees', methods: ['GET'])]
    public function listEmployees(EmployeeRepository $employeeRepository): Response
    {
        $employees = $employeeRepository->findAll();

        return $this->render('presence/employees.html.twig', [
            'employees' => $employees,
        ]);
    }


<<<<<<< HEAD
    #[Route('/presenceback', name: 'app_presence_admin_index', methods: ['GET'])]
public function adminIndex(PresenceRepository $presenceRepository): Response
{
    return $this->render('presence/indexback.html.twig', [
        'presences' => $presenceRepository->findAll(),
    ]);
}

=======


    #[Route('/presenceback', name: 'app_presence_admin_index', methods: ['GET'])]
public function adminIndex(
    Request $request,
    PresenceRepository $presenceRepository
): Response {
    $search = $request->query->get('search');
    $sort = $request->query->get('sort', 'date');
    $direction = $request->query->get('direction', 'asc');

    $presences = $presenceRepository->searchAndSort($search, $sort, $direction);

    $retardataires = $presenceRepository->findEmployeesWith3ConsecutiveLateDays();

    return $this->render('presence/indexback.html.twig', [
        'presences' => $presences,
        'direction' => $direction,
        'sort' => $sort,
        'retardataires' => $retardataires, // ✅ transmis à Twig
    ]);
}


>>>>>>> origin/asma_gestion_presence
    

    #[Route('/employee/{id}', name: 'app_presence_by_employee', methods: ['GET'])]
    public function showPresences(int $id, PresenceRepository $presenceRepository): Response
    {
        $presences = $presenceRepository->findBy(['employee' => $id]);

        return $this->render('presence/show_by_employee.html.twig', [
            'presences' => $presences,
            'employee_id' => $id,
        ]);
    }

<<<<<<< HEAD
    #[Route('/', name: 'app_presence_index', methods: ['GET'])]
>>>>>>> origin/ons_gestion_recrutement
=======
    #[Route('/employee/{id}', name: 'app_presence_by_employee', methods: ['GET'])]
    public function showBackPresencesBack(int $id, PresenceRepository $presenceRepository): Response
    {
        $presences = $presenceRepository->findBy(['employee' => $id]);

        return $this->render('presence/showBack_by_employee.html.twig', [
            'presences' => $presences,
            'employee_id' => $id,
        ]);
    }


    #[Route('/', name: 'app_presence_index', methods: ['GET'])]
>>>>>>> origin/asma_gestion_presence
    public function index(PresenceRepository $presenceRepository): Response
    {
        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository->findAll(),
        ]);
    }
<<<<<<< HEAD
<<<<<<< HEAD

    #[Route('/new', name: 'app_presence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $presence = new Presence();
        $form = $this->createForm(PresenceType::class, $presence);
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

    #[Route('/{id_presence}', name: 'app_presence_show', methods: ['GET'])]
    public function show(Presence $presence): Response
    {
        return $this->render('presence/show.html.twig', [
            'presence' => $presence,
        ]);
    }

=======
=======
>>>>>>> origin/asma_gestion_presence
    

    #[Route('/new', name: 'app_presence_new', methods: ['GET', 'POST'])]
public function new(
    Request $request,
    EntityManagerInterface $entityManager,
    RhRepository $rhRepository
): Response {
    $presence = new Presence();

    $now = new \DateTimeImmutable();
<<<<<<< HEAD
    $presence->setDate($now);
    $presence->setHeureArrive($now);
=======
    $heureArrive = $now->modify('+1 hour');

    $presence->setDate($now);
    $presence->setHeureArrive($heureArrive);
>>>>>>> origin/asma_gestion_presence

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

<<<<<<< HEAD
        return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
=======
        return $this->redirectToRoute('app_presence_departure');
>>>>>>> origin/asma_gestion_presence
    }

    return $this->render('presence/new.html.twig', [
        'presence' => $presence,
        'form' => $form,
    ]);
}



<<<<<<< HEAD
=======

>>>>>>> origin/asma_gestion_presence
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


<<<<<<< HEAD
=======
#[Route('/alertes-retards', name: 'app_alertes_retards')]
public function retards(PresenceRepository $presenceRepository): Response
{
    $retardataires = $presenceRepository->findEmployeesWith3ConsecutiveLateDays();

    return $this->render('presence/retards.html.twig', [
        'retardataires' => $retardataires,
    ]);
}


>>>>>>> origin/asma_gestion_presence


#[Route('/{id_presence}', name: 'app_presence_show', methods: ['GET'])]
public function show(Presence $presence): Response
{
    $employeeId = $presence->getEmployee()?->getEmployeeId(); // ⚠️ ou getId() selon ton entité

    return $this->render('presence/show.html.twig', [
        'presence' => $presence,
        'employee_id' => $employeeId, // ✅ Cette ligne est essentielle pour éviter l’erreur
    ]);
}

<<<<<<< HEAD

    

>>>>>>> origin/ons_gestion_recrutement
=======
#[Route('/{id_presence}', name: 'app_presence_showBack', methods: ['GET'])]
public function showBack(Presence $presence): Response
{
    $employeeId = $presence->getEmployee()?->getEmployeeId(); // ⚠️ ou getId() selon ton entité

    return $this->render('presence/showBack.html.twig', [
        'presence' => $presence,
        'employee_id' => $employeeId, // ✅ Cette ligne est essentielle pour éviter l’erreur
    ]);
}


    

>>>>>>> origin/asma_gestion_presence
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
<<<<<<< HEAD
<<<<<<< HEAD
        if ($this->isCsrfTokenValid('delete'.$presence->getId_presence(), $request->getPayload()->getString('_token'))) {
=======
        if ($this->isCsrfTokenValid('delete' . $presence->getId_presence(), $request->getPayload()->getString('_token'))) {
>>>>>>> origin/ons_gestion_recrutement
=======
        if ($this->isCsrfTokenValid('delete' . $presence->getId_presence(), $request->getPayload()->getString('_token'))) {
>>>>>>> origin/asma_gestion_presence
            $entityManager->remove($presence);
            $entityManager->flush();
        }

<<<<<<< HEAD
        return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
    }
<<<<<<< HEAD
}
=======
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
=======
        return $this->redirectToRoute('app_presence_indexback', [], Response::HTTP_SEE_OTHER);
    }
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

    // ❗️Important : rediriger vers l'écran de pointage départ
    return $this->redirectToRoute('app_presence_departure');
}

>>>>>>> origin/asma_gestion_presence
    
    
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
    
<<<<<<< HEAD
        $presence->setHeureDepart(new \DateTime());
        $entityManager->flush();
=======
        $heureDepart = (new \DateTime())->modify('+1 hour');
        $presence->setHeureDepart($heureDepart);
                $entityManager->flush();
>>>>>>> origin/asma_gestion_presence
    
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
    

<<<<<<< HEAD
    

    
    
}
>>>>>>> origin/ons_gestion_recrutement
=======
    #[Route('/presence/departure', name: 'app_presence_departure')]
public function departure(
    Request $request, 
    PresenceRepository $presenceRepository, 
    EntityManagerInterface $em
): Response 
{
    $today = new \DateTimeImmutable('today');

    $presence = $presenceRepository->createQueryBuilder('p')
        ->where('p.date = :today')
        ->orderBy('p.id_presence', 'DESC') // ✅ utiliser "id_presence" ici
        ->setParameter('today', $today)
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

    if (!$presence) {
        throw $this->createNotFoundException('Aucune présence trouvée aujourd’hui.');
    }

    if ($request->isMethod('POST')) {
        // Ajouter 1 heure à l'heure actuelle pour HeureDepart
        $heureDepart = (new \DateTime())->modify('+1 hour');
        $presence->setHeureDepart($heureDepart);
        
        $em->flush();

        $this->addFlash('success', 'Départ enregistré avec succès.');
        return $this->redirectToRoute('app_presence_index');
    }

    return $this->render('presence/departure.html.twig', [
        'presence' => $presence,
    ]);
}


// src/Controller/PresenceController.php
#[Route('/presence/today', name: 'app_presence_today')]
public function today(PresenceRepository $presenceRepository): Response
{
    $today = new \DateTimeImmutable('today');
    $presences = $presenceRepository->findBy(['date' => $today]);

    return $this->render('presence/today.html.twig', [
        'presences' => $presences,
    ]);
}





    
}
>>>>>>> origin/asma_gestion_presence
