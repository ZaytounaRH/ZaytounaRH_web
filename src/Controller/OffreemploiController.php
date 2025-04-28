<?php

namespace App\Controller;

use App\Entity\Offreemploi;
use App\Form\OffreemploiType;
use App\Repository\OffreemploiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offreemploi')]
final class OffreemploiController extends AbstractController
{
    #[Route(name: 'app_offreemploi_index', methods: ['GET', 'POST'])]
    public function index(Request $request, OffreemploiRepository $offreemploiRepository): Response
    {
        // Récupérer les critères de tri et de direction
        $sort = $request->query->get('sort', 'datePublication');
        $direction = strtoupper($request->query->get('direction', 'DESC'));
        $statutFilter = $request->query->get('statut', ''); // Récupérer le statut sélectionné
    
        // Liste des critères de tri autorisés
        $allowedSortFields = ['salaire', 'datePublication'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'datePublication';
        }
    
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $direction = 'DESC';
        }
    
        // Récupérer les offres d'emploi triées selon les critères
        $qb = $offreemploiRepository->createQueryBuilder('o');
    
        // Appliquer le tri sélectionné
        $qb->addOrderBy('o.' . $sort, $direction);
    
        // Appliquer le filtre sur le statut si un statut est sélectionné
        if ($statutFilter) {
            $qb->andWhere('o.statut = :statut')
                ->setParameter('statut', $statutFilter);
        }
    
        // Exécuter la requête
        $offreemplois = $qb->getQuery()->getResult();
    
        return $this->render('offreemploi/index.html.twig', [
            'offreemplois' => $offreemplois,
            'currentSort' => $sort,
            'currentDirection' => $direction,
            'currentStatut' => $statutFilter, // Passer le statut sélectionné à la vue
        ]);
    }
    

    #[Route('/new', name: 'app_offreemploi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offreemploi = new Offreemploi();
        $form = $this->createForm(OffreemploiType::class, $offreemploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offreemploi);
            $entityManager->flush();

            return $this->redirectToRoute('app_offreemploi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offreemploi/new.html.twig', [
            'offreemploi' => $offreemploi,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offreemploi_show', methods: ['GET'])]
    public function show(Offreemploi $offreemploi): Response
    {
        return $this->render('offreemploi/show.html.twig', [
            'offreemploi' => $offreemploi,
        ]);
    }

    #[Route('/{idOffre}/edit', name: 'app_offreemploi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offreemploi $offreemploi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreemploiType::class, $offreemploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offreemploi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offreemploi/edit.html.twig', [
            'offreemploi' => $offreemploi,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offreemploi_delete', methods: ['POST'])]
    public function delete(Request $request, Offreemploi $offreemploi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offreemploi->getIdOffre(), $request->request->get('_token'))) {
            $entityManager->remove($offreemploi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offreemploi_index', [], Response::HTTP_SEE_OTHER);
    }
}
