<?php

namespace App\Controller;

use App\Entity\Rh;
use App\Form\RhType;
use App\Repository\RhRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rh')]
final class RhController extends AbstractController
{
    #[Route(name: 'app_rh_index', methods: ['GET'])]
    public function index(RhRepository $rhRepository): Response
    {
        return $this->render('rh/index.html.twig', [
            'rhs' => $rhRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rh_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rh = new Rh();
        $form = $this->createForm(RhType::class, $rh);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rh);
            $entityManager->flush();

            return $this->redirectToRoute('app_rh_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rh/new.html.twig', [
            'rh' => $rh,
            'form' => $form,
        ]);
    }

    #[Route('/{rh_id}', name: 'app_rh_show', methods: ['GET'])]
    public function show(Rh $rh): Response
    {
        return $this->render('rh/show.html.twig', [
            'rh' => $rh,
        ]);
    }

    #[Route('/{rh_id}/edit', name: 'app_rh_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rh $rh, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RhType::class, $rh);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rh_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rh/edit.html.twig', [
            'rh' => $rh,
            'form' => $form,
        ]);
    }

    #[Route('/{rh_id}', name: 'app_rh_delete', methods: ['POST'])]
    public function delete(Request $request, Rh $rh, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rh->getRh_id(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rh);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rh_index', [], Response::HTTP_SEE_OTHER);
    }
}