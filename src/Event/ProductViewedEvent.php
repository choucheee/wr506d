<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Événement déclenché lorsqu'un produit est visualisé
 */
class ProductViewedEvent extends Event
{
    public function __construct(
        private readonly string $productId,
        private readonly string $productTitle,
        private readonly string $productSlug
    ) {
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getProductTitle(): string
    {
        return $this->productTitle;
    }

    public function getProductSlug(): string
    {
        return $this->productSlug;
    }
}

