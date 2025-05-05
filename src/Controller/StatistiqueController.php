<?php

namespace App\Controller;

use App\Repository\OffreemploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'app_offreemploi_statistique')]
public function statistique(OffreemploiRepository $offreemploiRepository): Response
{
    // 1. Liste de tes statuts définis
    $statutsPossibles = [
        'OUVERTE',
        'FERMEE',
        'POURVUE',
        'ANNULEE',
        'ENCOURS',
    ];

    // 2. Récupérer les statistiques réelles depuis la base
    $resultats = $offreemploiRepository->createQueryBuilder('o')
        ->select('o.statut, COUNT(o.idOffre) as nombre')
        ->groupBy('o.statut')
        ->getQuery()
        ->getResult();

    // 3. Initialiser tous les statuts à 0
    $statistiques = [];
    foreach ($statutsPossibles as $statut) {
        $statistiques[$statut] = 0;
    }

    // 4. Remplir avec les vraies données
    foreach ($resultats as $row) {
        if (isset($statistiques[$row['statut']])) {
            $statistiques[$row['statut']] = $row['nombre'];
        }
    }

    // 5. Formater pour l'envoyer à Twig
    $formattedStats = [];
    foreach ($statistiques as $statut => $nombre) {
        $formattedStats[] = [
            'statut' => $statut,
            'nombre' => $nombre,
        ];
    }

    return $this->render('offreemploi/statistique.html.twig', [
        'statistiques' => $formattedStats,
    ]);
}

}
