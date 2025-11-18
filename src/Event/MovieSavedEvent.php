<?php

namespace App\Event;

use App\Entity\Movie;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Événement déclenché lorsqu'un film (Movie) est sauvegardé
 */
class MovieSavedEvent extends Event
{
    public function __construct(
        private readonly Movie $movie
    ) {
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }
}

