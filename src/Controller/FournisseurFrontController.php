<?php
namespace App\Controller;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fournisseur')]
final class FournisseurFrontController extends AbstractController
{
    #[Route('/', name: 'front_fournisseur_index', methods: ['GET'])]
    public function index(Request $request, FournisseurRepository $fournisseurRepository): Response
    {
        // Récupérer la valeur de la recherche dans les paramètres de la requête (URL)
        $search = $request->query->get('search', '');

        // Utiliser le repository pour récupérer les fournisseurs filtrés par nom
        $fournisseurs = $fournisseurRepository->findBySearch($search);

        // Rendu de la vue avec la liste des fournisseurs
        return $this->render('front/fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurs,
            'search' => $search,  // Passer le terme de recherche au template
        ]);
    }

    #[Route('/{id}', name: 'front_fournisseur_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur): Response
    {
        // Rendu de la vue avec les détails du fournisseur
        return $this->render('front/fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }
}
