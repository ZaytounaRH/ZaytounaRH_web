<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BackController extends AbstractController
{
    #[Route('/back', name: 'admin_dashboard')]
public function index(): Response
{
    return $this->render('back/index.html.twig');
}

}