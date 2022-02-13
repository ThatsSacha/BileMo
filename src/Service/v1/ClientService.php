<?php

namespace App\v1\Service;

use App\Entity\v1\User;
use App\Repository\v1\ClientRepository;
use App\Service\AbstractRestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ClientService extends AbstractRestService {
    private $repo;

    public function __construct(
        ClientRepository $repo
    ) {
        $this->repo = $repo;
    }

    public function findOneBy(array $criteria) {
        return $this->repo->findOneBy($criteria);
    }
}