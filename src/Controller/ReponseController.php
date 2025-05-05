<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Reclamation;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponse')]
final class ReponseController extends AbstractController
{
    #[Route('/', name: 'app_reponse_index', methods: ['GET'])]
    public function index(ReponseRepository $reponseRepository, Request $request): Response
    {
        // Récupérer la page actuelle, 1 par défaut
        $page = $request->query->getInt('page', 1);
        
        // Nombre d'éléments par page
        $limit = 3;
        
        // Appel de la méthode pour récupérer les réponses paginées
        $reponses = $reponseRepository->findAllOrderByDateRepDescPaginated($page, $limit);
        
        // Passer les données à la vue (pagination ne sera pas utilisée ici, car on gère manuellement la page)
        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponses,
            'current_page' => $page,
            'limit' => $limit,
        ]);
    }

    #[Route('/new', name: 'app_reponse_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $reponse = new Reponse();
    $form = $this->createForm(ReponseType::class, $reponse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer la réclamation associée
        $reclamation = $reponse->getReclamation();

        // Mettre à jour le statut de la réclamation
        if ($reclamation) {
            $reclamation->setStatut('RESOLU');  // Mise à jour du statut
            $entityManager->persist($reclamation);  // Persister la réclamation modifiée
        }

        // Persister la réponse
        $reponse->setDateRep(new \DateTimeImmutable());
        $entityManager->persist($reponse);
        $entityManager->flush();  // Sauvegarder les deux : la réclamation et la réponse

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('reponse/new.html.twig', [
        'reponse' => $reponse,
        'form' => $form,
    ]);
}

    
    #[Route('/{idRep}', name: 'app_reponse_show', methods: ['GET'])]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    #[Route('/{idRep}/edit', name: 'app_reponse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{idRep}', name: 'app_reponse_delete', methods: ['POST'])]
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getIdRep(), $request->get('_token'))) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }
}
