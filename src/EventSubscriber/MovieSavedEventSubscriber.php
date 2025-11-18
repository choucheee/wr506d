<?php

namespace App\EventSubscriber;

use App\Entity\LogAction;
use App\Event\MovieSavedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * EventSubscriber Symfony qui écoute l'événement MovieSavedEvent
 * et crée un LogAction pour enregistrer l'action
 */
class MovieSavedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Retourne les événements auxquels cet écouteur s'abonne
     *
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MovieSavedEvent::class => 'onMovieSaved',
        ];
    }

    /**
     * Méthode appelée lorsqu'un film est sauvegardé
     *
     * @param MovieSavedEvent $event L'événement de sauvegarde de film
     */
    public function onMovieSaved(MovieSavedEvent $event): void
    {
        $movie = $event->getMovie();

        // Log pour débogage
        error_log('MovieSavedEventSubscriber: Événement reçu, Movie ID = ' . ($movie->getId() ?? 'null'));

        // Vérification que le film a bien un ID (doit être sauvegardé)
        if ($movie->getId() === null) {
            error_log('MovieSavedEventSubscriber: Le film n\'a pas d\'ID, abandon');
            return; // Le film n'a pas encore d'ID, on ne peut pas créer le log
        }

        // Création d'un LogAction pour enregistrer l'action
        $logAction = new LogAction();
        $logAction->setAction('movie_saved');
        $logAction->setEntityType('Movie');
        $logAction->setEntityId($movie->getId());
        
        // Détails du film sauvegardé
        $details = sprintf(
            'Film sauvegardé: "%s" (Réalisateur: %s, Année: %s)',
            $movie->getTitle() ?? 'N/A',
            $movie->getDirector() ?? 'N/A',
            $movie->getYear() ?? 'N/A'
        );
        $logAction->setDetails($details);

        error_log('MovieSavedEventSubscriber: Tentative de sauvegarde du LogAction');

        // Sauvegarde du LogAction dans une nouvelle transaction pour éviter les problèmes
        try {
            $this->entityManager->persist($logAction);
            $this->entityManager->flush();
            error_log('MovieSavedEventSubscriber: LogAction sauvegardé avec succès, ID = ' . $logAction->getId());
        } catch (\Exception $e) {
            // En cas d'erreur, on log mais on ne bloque pas le processus
            error_log('Erreur lors de la création du LogAction: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
        }
    }
}

