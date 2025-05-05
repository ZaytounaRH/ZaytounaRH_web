<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotificationEmail(string $adminEmail, string $commandeId): void
    {
        $email = (new Email())
            ->from('dournath@gmail.com') 
            ->to($adminEmail)
            ->subject('Nouvelle Commande Ajoutée')
            ->html("<p>Une nouvelle commande a été ajoutée avec l'ID: <strong>$commandeId</strong></p>");

        $this->mailer->send($email);
    }
}
