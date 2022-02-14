<?php

namespace App\Service\v1;

use App\Repository\ProductRepository;
use App\Service\AbstractRestService;
use Symfony\Component\HttpFoundation\Response;

class ProductService extends AbstractRestService {
    private $repo;

    public function __construct(
        ProductRepository $repo
    ) {
       $this->repo = $repo;
    }

    /**
     * @return array
     */
    public function findAll(): array {
        $products = $this->repo->findAll();
        $productsSerialized = [];
    
        foreach ($products as $product) {
            $productsSerialized[] = $product->jsonSerialize();
        }

        return [
            'status' => Response::HTTP_OK,
            'data' => $productsSerialized
        ];
    }
}