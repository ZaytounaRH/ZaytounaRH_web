<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends AbstractController
{
    #[Route("/chat", name :"chat")]
    public function index(): Response
    {
        $response = $this->render('chatbot/chat.html.twig');

        // Mise à jour de la politique CSP
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://www.gstatic.com https://www.google.com https://dialogflow.cloud.google.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' https://fonts.gstatic.com; " .
            "connect-src 'self' https://dialogflow.cloud.google.com; " .
            "frame-src 'self' https://bot.dialogflow.com;");

        return $response;
    }
}
