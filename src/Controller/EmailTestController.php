<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailTestController extends AbstractController
{
    #[Route('/send-test', name: 'send_test')]
    public function sendEmail(): Response
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'zaytounarh@gmail.com'; // Ton email Gmail
            $mail->Password = 'lvjy cymj bnhw sbhe';   // Ton mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Expéditeur et Destinataire
            $mail->setFrom('zaytounarh@gmail.com');
            $mail->addAddress('allanimimou@gmail.com');

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Test d\'envoi avec PHPMailer';
            $mail->Body    = '<h1>Email de Test</h1><p>Envoyé depuis Symfony + PHPMailer</p>';
            $mail->AltBody = 'Email de Test - Envoyé depuis Symfony + PHPMailer (version texte)';

            $mail->send();

            return new Response('Email envoyé avec succès !');
        } catch (Exception $e) {
            return new Response('Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo);
        }
    }

}
