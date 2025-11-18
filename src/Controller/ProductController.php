<?php

namespace App\Controller;

use App\Service\ProductEventService;
use App\Service\SlugifierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(
        private readonly SlugifierService $slugifierService,
        private readonly ProductEventService $productEventService
    ) {
    }

    #[Route('/products', name: 'app_products_list')]
    public function listProducts(): Response
    {
        return $this->render('product/list.html.twig');
    }

    #[Route('/product/{id}', name: 'product_view')]
    public function viewProduct(Request $request): Response
    {
        // Récupération du paramètre id depuis la requête (paramètre de route)
        $id = $request->attributes->get('id');
        
        // Exemple de titre produit
        $productTitle = "T-Shirt d'Été !";
        
        // Slugification du titre
        $slug = $this->slugifierService->slugify($productTitle);
        
        // Déclenchement de l'événement de visualisation du produit
        $this->productEventService->dispatchProductViewed($id, $productTitle, $slug);
        
        return $this->render('product/view.html.twig', [
            'id' => $id,
            'title' => $productTitle,
            'slug' => $slug,
        ]);
    }
}

