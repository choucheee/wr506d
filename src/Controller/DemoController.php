<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DemoController extends AbstractController
{
    #[Route('/demo', name: 'app_demo')]
    public function index(): Response
    {
        // Définir la timezone (Europe/Paris pour la France)
        $timezone = new \DateTimeZone('Europe/Paris');
        $date = new \DateTime('now', $timezone);
        
        // Formater la date en français
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            $timezone,
            \IntlDateFormatter::GREGORIAN,
            'EEEE d MMMM yyyy'
        );
        
        $dateFormatee = $formatter->format($date);
        
        // Capitaliser uniquement la première lettre de la chaîne
        $dateFormatee = mb_strtoupper(mb_substr($dateFormatee, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($dateFormatee, 1, null, 'UTF-8');
        
        return $this->render('demo/index.html.twig', [
            'date' => $dateFormatee,
        ]);
    }
}

