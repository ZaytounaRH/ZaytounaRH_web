<?php
namespace App\Controller;

use App\Entity\Assurance;
use App\Form\RechercheAssuranceType;
use App\Repository\AssuranceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recherche-assurance')]
class RechercheAssuranceController extends AbstractController
{
    #[Route('/', name: 'app_recherche_assurance', methods: ['GET', 'POST'])]
    public function search(Request $request, AssuranceRepository $assuranceRepository): Response
    {
        // Création du formulaire de recherche
        $form = $this->createForm(RechercheAssuranceType::class);
        $form->handleRequest($request);

        // Initialisation de la variable pour stocker le type d'assurance sélectionné
        $typeAssurance = null;

        // Si le formulaire est soumis et valide, on récupère le type d'assurance
        if ($form->isSubmitted() && $form->isValid()) {
            $typeAssurance = $form->getData()['typeAssurance'];
        }

        // Création de la requête pour récupérer les assurances
        $queryBuilder = $assuranceRepository->createQueryBuilder('a');

        // Si un type d'assurance est sélectionné, filtrer les résultats
        if ($typeAssurance) {
            $queryBuilder->where('a.type = :type')
                         ->setParameter('type', $typeAssurance);
        }

        // Récupérer les résultats filtrés
        $assurances = $queryBuilder->getQuery()->getResult();

        return $this->render('assurance/recherche.html.twig', [
            'form' => $form->createView(),
            'assurances' => $assurances,
        ]);
    }
}
