<?php
// src/Controller/CalendarController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarOffreController extends AbstractController
{
    #[Route('/calendarOffre', name: 'app_calendarOffre')]
    public function index(): Response
    {
        return $this->render('offreemploi/calendarOffre.html.twig');
    }


    
}
