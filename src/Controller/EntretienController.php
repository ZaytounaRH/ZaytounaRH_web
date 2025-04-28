<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Form\EntretienType;
use App\Repository\EntretienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/entretien')]
final class EntretienController extends AbstractController
{
    #[Route(name: 'app_entretien_index', methods: ['GET'])]
    public function index(EntretienRepository $entretienRepository): Response
    {
       // Vous pouvez trier les entretiens par l'offre d'emploi
    $entretiens = $entretienRepository->findBy(
        [],
        ['offreemploi' => 'ASC'] // Tri par offreEmploi et dateEntretien
    );

    return $this->render('entretien/index.html.twig', [
        'entretiens' => $entretiens,
    ]);


    }



    #[Route('/entretien/trier-date', name: 'entretien_trier_date', methods: ['GET'])]
public function trierParDate(EntretienRepository $entretienRepository, Request $request): Response
{
    // Lire le paramètre 'order' dans l'URL (par défaut 'ASC')
    $order = $request->query->get('order', 'ASC');
 
    // Chercher les entretiens triés par date selon l'ordre
    $entretiens = $entretienRepository->findBy([], ['dateEntretien' => $order]);

    // Retourner la vue avec les entretiens triés
    return $this->render('entretien/index.html.twig', [
        'entretiens' => $entretiens,
        'order' => $order, // Pour afficher l'ordre actuel dans le template Twig
    ]);
}

    


    #[Route('/new', name: 'app_entretien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entretien = new Entretien();
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $cvFile */
            $cvFile = $form->get('cv')->getData(); // Récupère le fichier uploadé

            if ($cvFile) {
                // Définir un nom unique pour le fichier (par exemple, avec un identifiant unique)
                $newFilename = uniqid() . '.' . $cvFile->guessExtension();

                // Déplacer le fichier vers le répertoire souhaité
                $cvFile->move(
                    $this->getParameter('upload_directory'), // Définir ce paramètre dans config/services.yaml
                    $newFilename
                );
                // Optionnel : Enregistrer le nom du fichier en session si nécessaire
                $request->getSession()->set('cv_filename', $newFilename);
            }

            // Pas besoin de persister d'informations sur le fichier dans la base de données
            $entityManager->persist($entretien);
            $entityManager->flush();

            return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form,
        ]);
    }

    #[Route('/{idEntretien}', name: 'app_entretien_show', methods: ['GET'])]
    public function show(Entretien $entretien): Response
    {
        return $this->render('entretien/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    #[Route('/{idEntretien}/edit', name: 'app_entretien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entretien $entretien, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form,
        ]);
    }

    #[Route('/{idEntretien}', name: 'app_entretien_delete', methods: ['POST'])]
    public function delete(Request $request, Entretien $entretien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $entretien->getIdEntretien(), $request->get('_token'))) {
            $entityManager->remove($entretien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/entretien/{id}/changer-statut/{statut}', name: 'changer_statut_entretien')]
    public function changerStatut(EntretienRepository $repository, EntityManagerInterface $em, int $id, string $statut): Response
    {
        $entretien = $repository->find($id);

        if (!$entretien) {
            throw $this->createNotFoundException('Entretien non trouvé.');
        }

        $entretien->setStatut($statut);
        $em->flush();

        return $this->redirectToRoute('app_entretien_index'); // Ou autre route selon ton système
    }
}
