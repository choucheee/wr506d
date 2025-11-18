<?php

namespace App\Service;

use App\Event\ProductViewedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Service responsable de la gestion des événements liés aux produits
 */
class ProductEventService
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * Déclenche l'événement lorsqu'un produit est visualisé
     *
     * @param string $productId L'identifiant du produit
     * @param string $productTitle Le titre du produit
     * @param string $productSlug Le slug du produit
     */
    public function dispatchProductViewed(string $productId, string $productTitle, string $productSlug): void
    {
        // Création de l'événement avec les données du produit
        $event = new ProductViewedEvent($productId, $productTitle, $productSlug);
        
        // Déclenchement de l'événement
        $this->eventDispatcher->dispatch($event);
    }
}

