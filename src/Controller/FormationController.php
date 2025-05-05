<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Certification;

use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\EmployeeRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




#[Route('/formation')]
final class FormationController extends AbstractController
{
    #[Route(name: 'app_formation_index', methods: ['GET'])]
public function index(Request $request, FormationRepository $formationRepository, EntityManagerInterface $em): Response
{
    // Récupération du paramètre "order" depuis l'URL (asc ou desc)
    $order = $request->query->get('order', 'asc');

    // Requête triée dynamiquement par dateDebutFormation
    $formations = $formationRepository->createQueryBuilder('f')
        ->orderBy('f.dateDebutFormation', $order === 'desc' ? 'DESC' : 'ASC')
        ->getQuery()
        ->getResult();

    // Génération automatique des certificats + envoi de mails
    $today = new \DateTime();

    foreach ($formations as $formation) {
        if ($formation->getDateFinFormation() && $formation->getDateFinFormation() <= $today) {
            foreach ($formation->getEmployees() as $employee) {
                $alreadyCertified = false;
                foreach ($formation->getCertifications() as $certif) {
                    if ($certif->getEmployees()->contains($employee)) {
                        $alreadyCertified = true;
                        break;
                    }
                }
                if (!$alreadyCertified) {
                    $certification = new Certification();
                    $certification->setTitreCertif('Certificat de formation : ' . $formation->getNomFormation());
                    $certification->setOrganismeCertif('ZaytounaRH');
                    $certification->setFormation($formation);
                    $certification->addEmployee($employee);
                    $em->persist($certification);

                    // Envoi d'email de satisfaction
                    $user = $employee->getUser();
                    if ($user && $user->getEmail()) {
                        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'zaytounarh@gmail.com'; // Gmail
                            $mail->Password = 'lvjy cymj bnhw sbhe'; // Mot de passe app Gmail
                            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom('zaytounarh@gmail.com', 'ZaytounaRH');
                            $mail->addAddress($user->getEmail());

                            $mail->isHTML(true);
                            $mail->Subject = 'Merci pour votre participation - Formation ' . $formation->getNomFormation();
                            $mail->Body = '
                                <p>Bonjour ' . htmlspecialchars($user->getPrenom()) . ',</p>
                                <p>Merci d\'avoir participé à la formation <strong>' . htmlspecialchars($formation->getNomFormation()) . '</strong>.</p>
                                <p>Nous vous serions reconnaissants de remplir ce court questionnaire de satisfaction Votre avis compte pour nous !</p>
                                <p><a href="https://docs.google.com/forms/d/e/1FAIpQLSdKs4avVch69CEFezGkjBQvJkpG_3dt0reEwkrEx5mRxe-nSQ/viewform?usp=header">Lien vers le questionnaire</a></p>
                                <p>Merci beaucoup,<br>L\'équipe ZaytounaRH</p>
                            ';
                            $mail->AltBody = 'Merci de remplir le questionnaire pour ' . $formation->getNomFormation();

                            $mail->send();
                        } catch (\PHPMailer\PHPMailer\Exception $e) {
                            // Ignorer l'erreur pour ne pas bloquer la page
                        }
                    }
                }
            }
        }
    }

    $em->flush();

    return $this->render('formation/index.html.twig', [
        'formations' => $formations,
        'order' => $order,
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
public function showCertif(Formation $formation, FormationRepository $formationRepository): Response
{
    $certifications = $formation->getCertifications();

    // Trouver formations similaires par mot-clé (exemple simple)
    $keyword = explode(' ', strtolower($formation->getNomFormation()))[0]; // premier mot du nom
    $similarFormations = $formationRepository->createQueryBuilder('f')
        ->where('f.nomFormation LIKE :keyword OR f.descriptionFormation LIKE :keyword')
        ->andWhere('f != :currentFormation')
        ->setParameter('keyword', '%' . $keyword . '%')
        ->setParameter('currentFormation', $formation)
        ->getQuery()
        ->getResult();

    return $this->render('formation/showCertif.html.twig', [
        'formation' => $formation,
        'certifications' => $certifications,
        'similarFormations' => $similarFormations, // On ajoute ici
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
    
    #[Route('/stats/formations', name: 'app_formation_stats', methods: ['GET'])]
public function stats(FormationRepository $formationRepository): JsonResponse
{
    $formations = $formationRepository->findAll();

    $data = [];
    foreach ($formations as $formation) {
        $data[] = [
            'nom' => $formation->getNomFormation(),
            'count' => count($formation->getEmployees()),
        ];
    }

    return $this->json($data);
}
#[Route('/formations/stats', name: 'app_formation_stats_view', methods: ['GET'])]
public function statsView(): Response
{
    return $this->render('formation/stats.html.twig');
}

#[Route('/formations/export/excel', name: 'app_formation_export_excel', methods: ['GET'])]
public function exportExcel(FormationRepository $formationRepo): Response
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Formations');

    // En-têtes
    $sheet->setCellValue('A1', 'Nom Formation');
    $sheet->setCellValue('B1', 'Date Début');
    $sheet->setCellValue('C1', 'Date Fin');
    $sheet->setCellValue('D1', 'Employé(s)');

    $formations = $formationRepo->findAll();
    $row = 2;

    foreach ($formations as $formation) {
        $sheet->setCellValue("A$row", $formation->getNomFormation());
        $sheet->setCellValue("B$row", $formation->getDateDebutFormation()?->format('Y-m-d'));
        $sheet->setCellValue("C$row", $formation->getDateFinFormation()?->format('Y-m-d'));

        // Rassembler les noms des employés
        $employeeNames = array_map(function ($e) {
            $user = $e->getUser();
            return $user ? $user->getNom() . ' ' . $user->getPrenom() : 'Inconnu';
        }, $formation->getEmployees()->toArray());
        $sheet->setCellValue("D$row", implode(', ', $employeeNames));

        $row++;
    }

    // Générer le fichier
    $writer = new Xlsx($spreadsheet);

    $response = new StreamedResponse(function () use ($writer) {
        $writer->save('php://output');
    });

    $filename = 'formations_' . date('Ymd_His') . '.xlsx';

    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', "attachment;filename=$filename");
    $response->headers->set('Cache-Control', 'max-age=0');

    return $response;
}

#[Route('/employee/agenda-data', name: 'employee_agenda_data')]
public function agendaData(Request $request, FormationRepository $formationRepo, EmployeeRepository $employeeRepo): JsonResponse
{
    $employeeId = $request->query->get('employee_id');

    if ($employeeId) {
        $employee = $employeeRepo->find($employeeId);

        if (!$employee) {
            return $this->json([]);
        }

        $formations = $employee->getFormations();
    } else {
        $formations = $formationRepo->findAll(); // fallback si pas d'ID
    }

    $events = [];

    foreach ($formations as $formation) {
        $events[] = [
            'title' => $formation->getNomFormation(),
            'start' => $formation->getDateDebutFormation()->format('Y-m-d'),
            'end' => $formation->getDateFinFormation()->format('Y-m-d'),
        ];
    }

    return $this->json($events);
}

#[Route('/employee/agenda', name: 'employee_agenda')]
public function agenda(): Response
{
    return $this->render('employee/agenda.html.twig');
}


#[Route('/formation/send-satisfaction-emails', name: 'send_satisfaction_emails')]
public function sendSatisfactionEmails(FormationRepository $formationRepo): Response
{
    $today = new \DateTime();
    $formations = $formationRepo->findAll();

    $mail = new PHPMailer(true);

    try {
        // Configurer ton SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zaytounarh@gmail.com'; // Ton Gmail
        $mail->Password = 'lvjy cymj bnhw sbhe';   // Mot de passe d'application Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('zaytounarh@gmail.com', 'ZaytounaRH');

        foreach ($formations as $formation) {
            if ($formation->getDateFinFormation() <= $today) {
                foreach ($formation->getEmployees() as $employee) {
                    $user = $employee->getUser();
                    if ($user && $user->getEmail()) {
                        $mail->clearAddresses(); // Nettoyer les destinataires avant d'en ajouter un nouveau
                        $mail->addAddress($user->getEmail());

                        $mail->isHTML(true);
                        $mail->Subject = 'Questionnaire de satisfaction - Formation ' . $formation->getNomFormation();
                        $mail->Body = '
                            <p>Bonjour ' . htmlspecialchars($user->getPrenom()) . ',</p>
                            <p>Merci d\'avoir participé à la formation <strong>' . htmlspecialchars($formation->getNomFormation()) . '</strong>.</p>
                            <p>Pourriez-vous prendre quelques instants pour remplir notre questionnaire de satisfaction ?</p>
                            <p><a href="#">👉 Remplir le questionnaire</a></p>
                            <p>Merci beaucoup,<br>L\'équipe ZaytounaRH</p>
                        ';
                        $mail->AltBody = 'Merci d\'avoir participé à la formation ' . $formation->getNomFormation() . '. Merci de remplir le questionnaire.';

                        $mail->send();
                    }
                }
            }
        }

        return new Response('✅ Emails de satisfaction envoyés avec succès !');
    } catch (Exception $e) {
        return new Response('❌ Erreur lors de l\'envoi des emails : ' . $mail->ErrorInfo);
    }
}

}
