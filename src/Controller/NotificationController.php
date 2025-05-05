<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'app_notification_index')]
    public function index(SessionInterface $session): Response
    {
        // Réinitialiser les notifications à 0 quand l'utilisateur ouvre la page
        $session->set('notif_count', 0);

        return $this->render('notification/index.html.twig', [
            'message' => 'Voici vos notifications !'
        ]);
    }

    #[Route('/notif-count', name: 'app_notification_count')]
    public function getNotifCount(SessionInterface $session): Response
    {
        // Récupérer le nombre actuel de notifications
        $count = $session->get('notif_count', 0);

        return new Response($count);
    }
}
