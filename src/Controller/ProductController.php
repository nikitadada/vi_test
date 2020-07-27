<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController {

    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function initAction()
    {
        $productsIds = $this->productService->generateProducts(20);
        return new JsonResponse(['productIds' => $productsIds]);
    }
}
