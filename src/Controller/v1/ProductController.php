<?php

namespace App\Controller\v1;

use Exception;
use App\Service\v1\ProductService;
use SebastianBergmann\Comparator\ExceptionComparator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/v1/product')]
class ProductController extends AbstractController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('', name: 'product_show_all', methods: ['GET'])]
    public function showAll(): JsonResponse
    {
        $show = $this->productService->findAll();

        return new JsonResponse($show, $show['status']);
    }

    #[Route('/{id}', name: 'product_show_detail', methods: ['GET'])]
    public function showDetail($id): JsonResponse
    {
        $show = $this->productService->findOneById($id);

        return new JsonResponse($show, $show['status']);
    }
}
