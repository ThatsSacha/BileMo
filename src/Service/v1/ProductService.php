<?php

namespace App\Service\v1;

use App\Service\AbstractRestService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductService extends AbstractRestService {
    private $repo;

    public function __construct(
        ProductRepository $repo,
        DenormalizerInterface $denormalizer,
        EntityManagerInterface $entityManagerInterface
    ) {
        parent::__construct($denormalizer, $repo, $entityManagerInterface);
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

    /**
     * @param $id
     * @return array
     */
    public function findOneById($id): array {
        if (is_numeric($id)) {
            $product = $this->findOneBy(['id' => $id]);

            if ($product !== null) {
                return [
                    'status' => Response::HTTP_OK,
                    'data' => $product->jsonSerialize()
                ];
            }
    
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'data' => 'Product not found'
            ];
        } else {
            return [
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => 'The ID parameter must be a numeric'
            ];
        }
    }
}