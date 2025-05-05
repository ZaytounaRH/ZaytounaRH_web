<?php

namespace App\Service;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class OCRService
{
    public function extractText(string $imagePath, string $lang = 'eng'): string
    {
        // Commande à exécuter
        $command = ['tesseract', $imagePath, 'stdout', '-l', $lang];

        // Utilisation de Process de Symfony
        $process = new Process($command);
        $process->run();

        // Vérifie les erreurs
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Retourne le texte OCR
        return $process->getOutput();
    }
}
