<?php

namespace App\EventSubscriber;

use App\Entity\Movie;
use App\Event\MovieSavedEvent;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * EventSubscriber Doctrine qui écoute les événements de cycle de vie de Doctrine
 * et déclenche un événement Symfony lors de la sauvegarde d'un Movie
 */
class MovieDoctrineEventSubscriber implements EventSubscriber
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * Retourne les événements Doctrine auxquels cet écouteur s'abonne
     *
     * @return array<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    /**
     * Appelé après la persistance d'une entité
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->handleEvent($args);
    }

    /**
     * Appelé après la mise à jour d'une entité
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->handleEvent($args);
    }

    /**
     * Gère l'événement de cycle de vie Doctrine
     */
    private function handleEvent(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // Vérifie si l'entité est de type Movie
        if ($entity instanceof Movie) {
            // Log pour débogage
            error_log('MovieDoctrineEventSubscriber: Movie détecté, ID = ' . ($entity->getId() ?? 'null'));
            
            // Crée et déclenche l'événement Symfony
            $event = new MovieSavedEvent($entity);
            $this->eventDispatcher->dispatch($event);
            
            error_log('MovieDoctrineEventSubscriber: Événement MovieSavedEvent dispatché');
        }
    }
}

