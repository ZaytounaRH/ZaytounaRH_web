<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Form\CertificationType;
use App\Repository\CertificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/certification')]
final class CertificationController extends AbstractController
{
    #[Route(name: 'app_certification_index', methods: ['GET'])]
    public function index(CertificationRepository $certificationRepository): Response
    {
        return $this->render('certification/index.html.twig', [
            'certifications' => $certificationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_certification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $certification = new Certification();
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($certification);
            $entityManager->flush();

            return $this->redirectToRoute('app_certification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('certification/new.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]);
    }

    #[Route('/{idCertif}', name: 'app_certification_show', methods: ['GET'])]
    public function show(Certification $certification): Response
    {
        return $this->render('certification/show.html.twig', [
            'certification' => $certification,
        ]);
    }

    #[Route('/{idCertif}/edit', name: 'app_certification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Certification $certification, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_certification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('certification/edit.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]);
    }

    #[Route('/{idCertif}', name: 'app_certification_delete', methods: ['POST'])]
    public function delete(Request $request, Certification $certification, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certification->getIdCertif(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($certification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_certification_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/certification/{idCertif}/pdf', name: 'app_certification_download_pdf')]
    public function downloadPdf(Certification $certification): Response
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->setIsRemoteEnabled(true); // Très important si un jour tu ajoutes d'autres images ou CSS externes
        $dompdf = new Dompdf($options);
    
        // Lecture de l'image et encodage en Base64
        $logoPath = $this->getParameter('kernel.project_dir') . '/public/assets/img/logo.png';
        $logoBase64 = base64_encode(file_get_contents($logoPath));

        $borderPath = $this->getParameter('kernel.project_dir') . '/public/assets/img/border.png';
        $borderBase64 = base64_encode(file_get_contents($borderPath));

       
    
        // Génération du HTML
        $html = $this->renderView('certification/pdf.html.twig', [
            'certification' => $certification,
            'logoBase64' => $logoBase64, 
            'borderBase64' => $borderBase64,
            
        ]);
    
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="certification_'. $certification->getIdCertif() .'.pdf"',
            ]
        );
    }
}
