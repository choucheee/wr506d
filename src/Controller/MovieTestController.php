<?php

namespace App\Controller;

use App\Entity\LogAction;
use App\Entity\Movie;
use App\Event\MovieSavedEvent;
use App\Repository\LogActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MovieTestController extends AbstractController
{
    #[Route('/test/movie/create', name: 'test_movie_create')]
    public function createMovie(
        EntityManagerInterface $entityManager,
        LogActionRepository $logActionRepository,
        EventDispatcherInterface $eventDispatcher
    ): Response {
        // Création d'un nouveau film
        $movie = new Movie();
        $movie->setTitle('Inception');
        $movie->setDirector('Christopher Nolan');
        $movie->setYear(2010);

        // Sauvegarde du film
        $entityManager->persist($movie);
        $entityManager->flush();

        // Déclenchement manuel de l'événement (solution de contournement si l'EventSubscriber Doctrine ne fonctionne pas)
        // Normalement, cela devrait être fait automatiquement par MovieDoctrineEventSubscriber
        $event = new MovieSavedEvent($movie);
        $eventDispatcher->dispatch($event);

        // Récupération de TOUS les logs pour voir ce qui se passe
        $allLogs = $logActionRepository->findAll();
        
        // Récupération du dernier LogAction créé pour ce film spécifique
        $lastLogAction = $logActionRepository->findOneBy(
            ['entityType' => 'Movie', 'entityId' => $movie->getId()],
            ['createdAt' => 'DESC']
        );

        // Récupération des logs pour les films
        $movieLogs = $logActionRepository->findBy(
            ['entityType' => 'Movie'],
            ['createdAt' => 'DESC'],
            10
        );

        // Affichage des résultats
        return $this->render('movie/test.html.twig', [
            'movie' => $movie,
            'logAction' => $lastLogAction,
            'allLogs' => $movieLogs,
            'debug' => [
                'movieId' => $movie->getId(),
                'totalLogs' => count($allLogs),
                'movieLogsCount' => count($movieLogs),
            ],
        ]);
    }

    #[Route('/test/movie/list-logs', name: 'test_movie_list_logs')]
    public function listLogs(LogActionRepository $logActionRepository): Response
    {
        // Récupération de tous les logs pour les films
        $logs = $logActionRepository->findBy(
            ['entityType' => 'Movie'],
            ['createdAt' => 'DESC'],
            20
        );

        return $this->render('movie/logs.html.twig', [
            'logs' => $logs,
        ]);
    }
}

