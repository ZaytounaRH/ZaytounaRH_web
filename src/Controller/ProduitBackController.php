<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produit')]
final class ProduitBackController extends AbstractController
{
    #[Route('/', name: 'back_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(), // Récupération de tous les produits
        ]);
    }

    #[Route('/new', name: 'back_produit_new', methods: ['GET', 'POST'])]
     public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
       $produit = new Produit();
       $form = $this->createForm(ProduitType::class, $produit);
       $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($produit);
        $entityManager->flush();

        // ➕ Message flash de succès
        $this->addFlash('success', 'Produit ajouté avec succès !');

        // ➕ Mise à jour du compteur de notifications (facultatif)
        $session = $request->getSession();
        $session->set('notif_count', $session->get('notif_count', 0) + 1);

        return $this->redirectToRoute('back_produit_index');
         }

    return $this->render('produit/new.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/{id}', name: 'back_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'back_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_produit_index'); // Redirige vers la liste des produits
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }

    #[Route('/delete/{id}', name: 'back_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_produit_index'); // Redirige vers la liste des produits après suppression
    }
}
