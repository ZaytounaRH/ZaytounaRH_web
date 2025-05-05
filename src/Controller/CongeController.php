<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\CongeType;
use App\Repository\CongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
<<<<<<< HEAD
=======
use Symfony\Component\Form\FormError;
>>>>>>> origin/ons_gestion_recrutement
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/conge')]
final class CongeController extends AbstractController
{
    #[Route(name: 'app_conge_index', methods: ['GET'])]
    public function index(CongeRepository $congeRepository): Response
    {
        return $this->render('conge/index.html.twig', [
            'conges' => $congeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_conge_new', methods: ['GET', 'POST'])]
<<<<<<< HEAD
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $conge = new Conge();
        $form = $this->createForm(CongeType::class, $conge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($conge);
            $entityManager->flush();

            return $this->redirectToRoute('app_conge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conge/new.html.twig', [
            'conge' => $conge,
            'form' => $form,
        ]);
    }

=======
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $conge = new Conge(); // le constructeur met 'EN_ATTENTE'

    $form = $this->createForm(CongeType::class, $conge, ['is_edit' => false]);
    $form->handleRequest($request);

    // 🔥 Force la valeur ici si le champ n’est pas présent dans le formulaire
    if ($form->isSubmitted() && $form->isValid()) {
        if (!$conge->getStatut()) {
            $conge->setStatut('EN_ATTENTE');
        }

        $entityManager->persist($conge);
        $entityManager->flush();

        $this->addFlash('success', 'Le congé a été créé avec succès.');
        return $this->redirectToRoute('app_conge_index');
    }

    return $this->render('conge/new.html.twig', [
        'form' => $form,
        'conge' => $conge
    ]);
}

    
    


>>>>>>> origin/ons_gestion_recrutement
    #[Route('/{id_conge}', name: 'app_conge_show', methods: ['GET'])]
    public function show(Conge $conge): Response
    {
        return $this->render('conge/show.html.twig', [
            'conge' => $conge,
        ]);
    }

    #[Route('/{id_conge}/edit', name: 'app_conge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conge $conge, EntityManagerInterface $entityManager): Response
    {
<<<<<<< HEAD
        $form = $this->createForm(CongeType::class, $conge);
=======
        $form = $this->createForm(CongeType::class, $conge, ['is_edit' => true]);
>>>>>>> origin/ons_gestion_recrutement
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

<<<<<<< HEAD
            return $this->redirectToRoute('app_conge_index', [], Response::HTTP_SEE_OTHER);
=======
            return $this->redirectToRoute('app_conge_index');
>>>>>>> origin/ons_gestion_recrutement
        }

        return $this->render('conge/edit.html.twig', [
            'conge' => $conge,
            'form' => $form,
        ]);
    }

    #[Route('/{id_conge}', name: 'app_conge_delete', methods: ['POST'])]
    public function delete(Request $request, Conge $conge, EntityManagerInterface $entityManager): Response
    {
<<<<<<< HEAD
        if ($this->isCsrfTokenValid('delete'.$conge->getId_conge(), $request->getPayload()->getString('_token'))) {
=======
        if ($this->isCsrfTokenValid('delete' . $conge->getId_conge(), $request->getPayload()->getString('_token'))) {
>>>>>>> origin/ons_gestion_recrutement
            $entityManager->remove($conge);
            $entityManager->flush();
        }

<<<<<<< HEAD
        return $this->redirectToRoute('app_conge_index', [], Response::HTTP_SEE_OTHER);
    }
}
=======
        return $this->redirectToRoute('app_conge_index');
    }
    #[Route( name: 'app_conge_indexback', methods: ['GET'])]
    public function indexback(CongeRepository $congeRepository): Response
    {
        return $this->render('conge/backindex.html.twig', [
            'conges' => $congeRepository->findAll(),
        ]);
    }
}
>>>>>>> origin/ons_gestion_recrutement
