<?php

namespace App\Controller;

use App\Entity\Offreemploi;
use App\Form\OffreemploiType;
use App\Repository\OffreemploiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\Routing\Attribute\Route;
=======
use Symfony\Component\Routing\Annotation\Route;
>>>>>>> origin/ons_gestion_recrutement

#[Route('/offreemploi')]
final class OffreemploiController extends AbstractController
{
<<<<<<< HEAD
    #[Route(name: 'app_offreemploi_index', methods: ['GET'])]
    public function index(OffreemploiRepository $offreemploiRepository): Response
    {
        return $this->render('offreemploi/index.html.twig', [
            'offreemplois' => $offreemploiRepository->findAll(),
        ]);
    }

=======
    #[Route(name: 'app_offreemploi_index', methods: ['GET', 'POST'])]
    public function index(Request $request, OffreemploiRepository $offreemploiRepository): Response
    {
        $sort = $request->query->get('sort', 'datePublication');
        $direction = strtoupper($request->query->get('direction', 'DESC'));
        $statutFilter = $request->query->get('statut', '');
        $search = $request->query->get('search', '');

        $allowedSortFields = ['salaire', 'datePublication'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'datePublication';
        }

        if (!in_array($direction, ['ASC', 'DESC'])) {
            $direction = 'DESC';
        }

        $qb = $offreemploiRepository->createQueryBuilder('o')->addOrderBy('o.' . $sort, $direction);

        if ($statutFilter) {
            $qb->andWhere('o.statut = :statut')
                ->setParameter('statut', $statutFilter);
        }



        if ($search) {
            $qb->andWhere('o.titreOffre LIKE :search OR o.description LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }


        $offreemplois = $qb->getQuery()->getResult();

        return $this->render('offreemploi/index.html.twig', [
            'offreemplois' => $offreemplois,
            'currentSort' => $sort,
            'currentDirection' => $direction,
            'currentStatut' => $statutFilter,
            'currentSearch' => $search, // ➔ pour afficher la recherche dans l'input Twig

        ]);
    }

    #[Route('/offreemploi/admin', name: 'app_offreemploi_back_index', methods: ['GET', 'POST'])]
public function indexBack(Request $request, OffreemploiRepository $offreemploiRepository): Response
{
    $sort = $request->query->get('sort', 'datePublication');
    $direction = strtoupper($request->query->get('direction', 'DESC'));
    $statutFilter = $request->query->get('statut', '');

    $allowedSortFields = ['salaire', 'datePublication'];
    if (!in_array($sort, $allowedSortFields)) {
        $sort = 'datePublication';
    }

    if (!in_array($direction, ['ASC', 'DESC'])) {
        $direction = 'DESC';
    }

    $qb = $offreemploiRepository->createQueryBuilder('o')->addOrderBy('o.' . $sort, $direction);

    if ($statutFilter) {
        $qb->andWhere('o.statut = :statut')
            ->setParameter('statut', $statutFilter);
    }

    $offreemplois = $qb->getQuery()->getResult();

    return $this->render('offreemploi/back.html.twig', [
        'offreemplois' => $offreemplois,
        'currentSort' => $sort,
        'currentDirection' => $direction,
        'currentStatut' => $statutFilter,
    ]);
}


>>>>>>> origin/ons_gestion_recrutement
    #[Route('/new', name: 'app_offreemploi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offreemploi = new Offreemploi();
        $form = $this->createForm(OffreemploiType::class, $offreemploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offreemploi);
            $entityManager->flush();

<<<<<<< HEAD
            return $this->redirectToRoute('app_offreemploi_index', [], Response::HTTP_SEE_OTHER);
=======
            return $this->redirectToRoute('app_offreemploi_back_index', [], Response::HTTP_SEE_OTHER);
>>>>>>> origin/ons_gestion_recrutement
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

<<<<<<< HEAD
            return $this->redirectToRoute('app_offreemploi_index', [], Response::HTTP_SEE_OTHER);
=======
            return $this->redirectToRoute('app_offreemploi_back_index', [], Response::HTTP_SEE_OTHER);
>>>>>>> origin/ons_gestion_recrutement
        }

        return $this->render('offreemploi/edit.html.twig', [
            'offreemploi' => $offreemploi,
            'form' => $form,
        ]);
    }

<<<<<<< HEAD
    #[Route('/{idOffre}', name: 'app_offreemploi_delete', methods: ['POST'])]
    public function delete(Request $request, Offreemploi $offreemploi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offreemploi->getIdOffre(), $request->getPayload()->getString('_token'))) {
=======



    #[Route('/admin/{idOffre}/edit', name: 'app_offreemploi_edit_back', methods: ['GET', 'POST'])]
    public function editBack(Request $request, Offreemploi $offreemploi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreemploiType::class, $offreemploi);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_offreemploi_back_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('offreemploi/edit_back.html.twig', [
            'offreemploi' => $offreemploi,
            'form' => $form,
        ]);
    }
    






    #[Route('/{idOffre}', name: 'app_offreemploi_delete', methods: ['POST'])]
    public function delete(Request $request, Offreemploi $offreemploi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offreemploi->getIdOffre(), $request->request->get('_token'))) {
>>>>>>> origin/ons_gestion_recrutement
            $entityManager->remove($offreemploi);
            $entityManager->flush();
        }

<<<<<<< HEAD
        return $this->redirectToRoute('app_offreemploi_index', [], Response::HTTP_SEE_OTHER);
    }
=======
        return $this->redirectToRoute('app_offreemploi_back_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{idOffre}/show_back', name: 'app_offreemploi_show_back', methods: ['GET'])]
public function showBack(Offreemploi $offreemploi): Response
{
    return $this->render('offreemploi/show_back.html.twig', [
        'offreemploi' => $offreemploi,
    ]);
}




 

>>>>>>> origin/ons_gestion_recrutement
}
