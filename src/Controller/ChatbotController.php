<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chatbot')]
class ChatbotController extends AbstractController
{
    #[Route('', name: 'app_chatbot', methods: ['GET', 'POST'])]
    public function chatbot(): Response
    {
        return $this->render('chatbot/chatbot.html.twig');
    }
}
