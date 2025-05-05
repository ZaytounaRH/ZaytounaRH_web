<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Entretien;
use App\Entity\Offreemploi;
use App\Form\EntretienCandidatType;
use Doctrine\ORM\EntityManagerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $entretien->setOffreemploi($offreemploi); // Associer automatiquement l'offre d'emploi

        // Créer le formulaire pour l'entretien
        $form = $this->createForm(EntretienCandidatType::class, $entretien);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Traiter le fichier CV
            

            // Si aucun statut n'est défini, on met par défaut "EN_COURS"
            if (null === $entretien->getStatut()) {
                $entretien->setStatut('EN_COURS');
            }

            // Si la date n'est pas définie, on la définit à aujourd'hui
            if (null === $entretien->getDateEntretien()) {
                $entretien->setDateEntretien(new \DateTime());
            }

            // Sauvegarder l'entretien
            $entityManager->persist($entretien);
            $entityManager->flush();

            // Envoi d'un email de confirmation au candidat
            $this->sendEmailConfirmation($entretien);

            // Redirection vers la page "merci"
            return $this->redirectToRoute('app_entretien_merci', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/newcandidat.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    private function sendEmailConfirmation(Entretien $entretien)
    {
        // Récupérer l'adresse e-mail du candidat
        $candidat = $entretien->getCandidat(); // Assurez-vous que Candidat est associé à Offreemploi
        $email = $candidat->getUser()->getEmail(); // Assurez-vous que Candidat a une méthode getEmail()

        // Si l'e-mail du candidat est présent
        if ($email) {
            // Configurer PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuration du serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'zaytounarh@gmail.com'; // Votre adresse Gmail
                $mail->Password = 'lvjy cymj bnhw sbhe'; // Votre mot de passe Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Définir l'expéditeur
                $mail->setFrom('zaytounarh@gmail.com', 'ZaytounaRH');
                // Définir le destinataire
                $mail->addAddress($email, $candidat->getUser()->getNom());

                // Contenu de l'e-mail
                $mail->isHTML(true);
                $mail->Subject = 'Confirmation de l\'entretien';
                $mail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            color: #333;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #fff;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        }
                        h2 {
                            color: #4CAF50;
                        }
                        p {
                            font-size: 16px;
                            line-height: 1.5;
                        }
                        .button {
                            background-color: #4CAF50;
                            color: white;
                            padding: 10px 20px;
                            text-decoration: none;
                            border-radius: 5px;
                            display: inline-block;
                        }
                        .footer {
                            font-size: 12px;
                            text-align: center;
                            color: #777;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>Bonjour " . $candidat->getUser()->getNom() . ",</h2>
                        <p>Nous sommes ravis de vous informer que votre entretien pour l'offre d'emploi '<strong>" . $entretien->getOffreemploi()->getTitreOffre() . "</strong>' a été planifié.</p>
                        <p>Vous pouvez consulter les détails de votre entretien et préparer vos questions via notre espace candidat.</p>
                        <p>Nous vous remercions de l'intérêt que vous portez à notre entreprise et nous sommes impatients de vous rencontrer.</p>
                        <p>Bien cordialement,</p>
                        <p><strong>L'équipe ZaytounaRH</strong></p>
                        <div class='footer'>
                            <p>Si vous avez des questions, n'hésitez pas à nous contacter à <a href='mailto:contact@zaytounarh.com'>contact@zaytounarh.com</a></p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                
                // Envoi de l'e-mail
                $mail->send();
            } catch (Exception $e) {
                // En cas d'erreur
                $this->addFlash('error', 'L\'e-mail de confirmation n\'a pas pu être envoyé. Erreur: ' . $mail->ErrorInfo);
            }
        }
    }

    #[Route('/entretien/merci', name: 'app_entretien_merci', methods: ['GET'])]
    public function merci(EntityManagerInterface $entityManager): Response
    {
        // Récupérer un candidat fictif avec l'ID 1
        $candidat = $entityManager->getRepository(Candidat::class)->find(4);

        if (!$candidat) {
            throw $this->createNotFoundException('Candidat non trouvé');
        }

        // Passer le candidat à la vue
        return $this->render('entretien/merci.html.twig', [
            'candidat' => $candidat, // Passer le candidat fictif
        ]);
    }

    #[Route('/entretien/mes-entretiens/{candidatId}', name: 'app_candidat_mes_entretiens')]
public function mesEntretiens(int $candidatId, EntityManagerInterface $entityManager): Response
{
    // Récupérer le candidat par son ID
    $candidat = $entityManager->getRepository(Candidat::class)->find($candidatId);

    if (!$candidat) {
        throw $this->createNotFoundException('Candidat non trouvé');
    }

    // Récupérer tous les entretiens associés à ce candidat
    $entretiens = $entityManager->getRepository(Entretien::class)
        ->findBy(['candidat' => $candidat]); // Chercher les entretiens par candidat

    return $this->render('entretien/mes_entretiens.html.twig', [
        'entretiens' => $entretiens,
        'candidat' => $candidat
    ]);
}




    #[Route('/candidats', name: 'app_candidats')]
    public function afficherCandidats(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les candidats
        $candidats = $entityManager->getRepository(Candidat::class)->findAll();
    
        return $this->render('entretien/liste.html.twig', [
            'candidats' => $candidats,
        ]);
    }
    


} 