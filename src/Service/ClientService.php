<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\ClientRepository;
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