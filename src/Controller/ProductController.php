<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
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
        
        return $this->render('product/view.html.twig', [
            'id' => $id,
        ]);
    }
}

