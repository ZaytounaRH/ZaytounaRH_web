<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class TestMailerController extends AbstractController
{
    #[Route('/test-mail', name: 'test_mail')]
    public function sendTestEmail(MailerInterface $mailer): Response
    {
        try {
            $email = (new Email())
                ->from('asma.z@esprit.tn')
                ->to('ton.email.perso@gmail.com') // mets ici un email que tu peux consulter
                ->subject('🧪 Test Email Symfony via Gmail')
                ->html('<p>✅ Ceci est un test de Symfony Mailer via Gmail SMTP.</p>');

            $mailer->send($email);

            return new Response('✅ Email envoyé avec succès !');
        } catch (\Exception $e) {
            return new Response('❌ Erreur d\'envoi : ' . $e->getMessage());
        }
    }
}
