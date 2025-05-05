<?php

namespace App\Controller;

use App\Service\OCRService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OCRController extends AbstractController
{
    #[Route('/ocr', name: 'app_ocr')]
    public function index(Request $request, OCRService $ocrService): Response
    {
        $texteReconnu = null;
        $texteModifie = null;

        if ($request->isMethod('POST')) {
            $file = $request->files->get('document');

            if ($file) {
                $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move($uploadsDir, $fileName);

                $imagePath = $uploadsDir . '/' . $fileName;

                $texteReconnu = $ocrService->extractText($imagePath, 'fra');
            }

            $texteModifie = $request->request->get('texteModifie');
        }

        return $this->render('ocr/index.html.twig', [
            'texte' => $texteReconnu,
            'texteModifie' => $texteModifie,
        ]);
    }

    #[Route('/export_pdf', name: 'export_pdf')]
    public function exportPDF(Request $request): Response
    {
        $texte = $request->query->get('texte');

        // Créer Dompdf avec options
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Contenu HTML avec personnalisation ZaytounaRH
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    color: #333;
                }
                header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                header h1 {
                    color: #4CAF50;
                    font-size: 32px;
                    margin-bottom: 5px;
                }
                header p {
                    color: #2e7d32;
                    font-size: 18px;
                    margin-top: 0;
                }
                .content {
                    border: 2px solid #4CAF50;
                    padding: 20px;
                    border-radius: 15px;
                    background-color: #f4fff4;
                    white-space: pre-wrap; /* Respecte les retours à la ligne */
                }
                footer {
                    position: fixed;
                    bottom: 10px;
                    left: 0;
                    right: 0;
                    text-align: center;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <header>
                <h1>ZaytounaRH Assurance</h1>
                <p>Gestion des documents scannés</p>
            </header>

            <div class="content">'.nl2br(htmlspecialchars($texte)).'</div>

            <footer>
                &copy; '.date('Y').' ZaytounaRH Assurance - Tous droits réservés
            </footer>
        </body>
        </html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="zaytouna_document.pdf"',
            ]
        );
    }
}
