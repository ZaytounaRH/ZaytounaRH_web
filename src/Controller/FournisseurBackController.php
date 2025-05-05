<?php
namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/fournisseur')]
final class FournisseurBackController extends AbstractController
{
    #[Route('/', name: 'back_fournisseur_index', methods: ['GET'])]
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('backend/fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(), // Bien envoyer la variable
        ]);
    }
    #[Route('/new', name: 'back_fournisseur_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $fournisseur = new Fournisseur();
    $form = $this->createForm(FournisseurType::class, $fournisseur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($fournisseur);
        $entityManager->flush();

        return $this->redirectToRoute('back_fournisseur_index');
    }

    return $this->render('backend/fournisseur/new.html.twig', [
        'form' => $form->createView(),
        'fournisseurs' => [], // Pass an empty array
    ]);
}

    #[Route('/{id}', name: 'back_fournisseur_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('backend/fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    #[Route('/{id}/edit', name: 'back_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseur $fournisseur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_fournisseur_index');
        }

        return $this->render('backend/fournisseur/edit.html.twig', [
            'form' => $form->createView(),
            'fournisseur' => $fournisseur,
        ]);
    }

    #[Route('/{id}', name: 'back_fournisseur_delete', methods: ['POST'])]
    public function delete(Request $request, Fournisseur $fournisseur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_fournisseur_index');
    }
}
