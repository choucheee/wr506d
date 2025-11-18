<?php

namespace App\EventSubscriber;

use App\Event\ProductViewedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Écouteur d'événements pour les visualisations de produits
 */
class ProductViewedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ?LoggerInterface $logger = null
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
            ProductViewedEvent::class => 'onProductViewed',
        ];
    }

    /**
     * Méthode appelée lorsqu'un produit est visualisé
     *
     * @param ProductViewedEvent $event L'événement de visualisation de produit
     */
    public function onProductViewed(ProductViewedEvent $event): void
    {
        $productId = $event->getProductId();
        $productTitle = $event->getProductTitle();
        $productSlug = $event->getProductSlug();

        // Log de l'événement si un logger est disponible
        if ($this->logger !== null) {
            $this->logger->info('Produit visualisé', [
                'product_id' => $productId,
                'product_title' => $productTitle,
                'product_slug' => $productSlug,
            ]);
        }

        // Ici, vous pouvez ajouter d'autres actions :
        // - Enregistrer dans une base de données
        // - Envoyer une notification
        // - Mettre à jour des statistiques
        // - etc.
    }
}

