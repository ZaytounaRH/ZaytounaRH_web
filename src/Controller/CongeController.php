<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\CongeType;
use App\Entity\User;
use App\Entity\Employee;
use App\Repository\CongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


#[Route('/conge')]
final class CongeController extends AbstractController
{

    

    #[Route(name: 'app_conge_index', methods: ['GET'])]
    public function index(CongeRepository $congeRepository): Response
    {
        return $this->render('conge/index.html.twig', [
            'conges' => $congeRepository->findAll(),
        ]);
    }

    #[Route('/back', name: 'app_conge_indexback', methods: ['GET'])]
    public function indexBack(CongeRepository $congeRepository): Response
    {
        return $this->render('conge/backindex.html.twig', [
            'conges' => $congeRepository->findAll(),
        ]);
    }

    #[Route('/pdf', name: 'app_conge_pdf', methods: ['GET'])]
    public function generatePdf(CongeRepository $congeRepository): Response
    {
        $conges = $congeRepository->findAll();

        $dompdf = new Dompdf(new Options([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]));

        $html = $this->renderView('conge/pdf.html.twig', [
            'conges' => $conges,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="liste_conges.pdf"'
            ]
        );
    }

    #[Route('/new', name: 'app_conge_new', methods: ['GET', 'POST'])]
#[Route('/newback', name: 'app_conge_newback', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $conge = new Conge();
    $form = $this->createForm(CongeType::class, $conge, ['is_edit' => false]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $employee = $conge->getEmployee(); // récupéré du formulaire

        if (!$employee) {
            $form->addError(new FormError("Veuillez sélectionner un employé."));
        } else {
            $motif = strtolower($conge->getMotif()); // ex: "maladie"
            $currentYear = (new \DateTime())->format('Y');
            $joursDemandes = $conge->getDateDebut()->diff($conge->getDateFin())->days + 1;

            // ❌ Appliquer la règle de quota SEULEMENT si le motif n’est pas "maladie"
            if ($motif !== 'maladie') {
                $joursPris = array_reduce(
                    $employee->getConges()
                        ->filter(fn($c) =>
                            strtolower($c->getMotif()) !== 'maladie' &&
                            $c->getStatut() !== 'REFUSE' &&
                            $c->getDateDebut()->format('Y') === $currentYear
                        )
                        ->toArray(),
                    fn($acc, $c) => $acc + $c->getDateDebut()->diff($c->getDateFin())->days + 1,
                    0
                );

                if (($joursPris + $joursDemandes) > 21) {
                    $form->addError(new FormError("❌ Limite dépassée : $joursPris jours déjà posés. Cette demande de $joursDemandes jours dépasse les 21 jours autorisés."));
                    return $this->render(
                        $request->attributes->get('_route') === 'app_conge_new' ? 'conge/new.html.twig' : 'conge/newback.html.twig',
                        ['form' => $form->createView(), 'conge' => $conge]
                    );
                }
            }

            // ✅ Ajout autorisé
            $entityManager->persist($conge);
            $entityManager->flush();

            $this->addFlash('success', '✅ Le congé a été ajouté avec succès.');
            return $this->redirectToRoute(
                $request->attributes->get('_route') === 'app_conge_new' ? 'app_conge_index' : 'app_conge_indexback'
            );
        }
    }

    return $this->render(
        $request->attributes->get('_route') === 'app_conge_new' ? 'conge/new.html.twig' : 'conge/newback.html.twig',
        ['form' => $form->createView(), 'conge' => $conge]
    );
}








#[Route('/{id_conge}', name: 'app_conge_showBack', methods: ['GET'])]
    public function showBack(Conge $conge): Response
    {
        return $this->render('conge/showBack.html.twig', [
            'conge' => $conge,
        ]);
    }


    #[Route('/{id_conge}', name: 'app_conge_show', methods: ['GET'])]
    public function show(Conge $conge): Response
    {
        return $this->render('conge/show.html.twig', [
            'conge' => $conge,
        ]);
    }

    #[Route('/{id_conge}/edit', name: 'app_conge_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Conge $conge, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(CongeType::class, $conge, ['is_edit' => true]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $employe = $conge->getEmployee();
        $user = $employe?->getUser();

        if ($user && $user->getEmail()) {
            $mail = new PHPMailer(true);

            try {
                // Configuration SMTP Gmail
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'midou2006.281161@gmail.com'; // Ton adresse Gmail
                $mail->Password = 'lrzbjnogtchbwedc'; // Ton mot de passe d'application Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Définir l'expéditeur
                $mail->setFrom('midou2006.281161@gmail.com', 'Service RH');
                // Définir le destinataire
                $mail->addAddress($user->getEmail(), $user->getNom());

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Mise à jour de votre demande de congé';
                $mail->Body = "
                    <html>
                    <body style='font-family: Arial, sans-serif;'>
                        <div style='background-color: #f9f9f9; padding: 20px; border-radius: 10px;'>
                            <h2 style='color: #4CAF50;'>Mise à jour de votre congé</h2>
                            <p>Bonjour " . htmlspecialchars($user->getNom()) . " " . htmlspecialchars($user->getPrenom()) . ",</p>
                            <p>Votre demande de congé du <strong>" . $conge->getDateDebut()->format('d/m/Y') . "</strong> au <strong>" . $conge->getDateFin()->format('d/m/Y') . "</strong> a été <strong>" . htmlspecialchars($conge->getStatut()) . "</strong>.</p>
                            <p>Merci pour votre confiance.</p>
                            <p>Service RH</p>
                        </div>
                    </body>
                    </html>
                ";

                $mail->send();
                $this->addFlash('success', 'Le congé a été modifié et l\'email a été envoyé avec succès.');
            } catch (Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'envoi de l\'email: ' . $mail->ErrorInfo);
            }
        } else {
            $this->addFlash('error', 'Utilisateur ou email introuvable.');
        }

        return $this->redirectToRoute('app_conge_indexback');
    }

    return $this->render('conge/edit.html.twig', [
        'conge' => $conge,
        'form' => $form->createView(),
    ]);
}












    #[Route('/{id_conge}', name: 'app_conge_delete', methods: ['POST'])]
    public function delete(Request $request, Conge $conge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $conge->getId_conge(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($conge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_conge_index');
    }



    
}