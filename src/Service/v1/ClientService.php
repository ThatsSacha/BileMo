<?php

namespace App\Service\v1;

use App\Entity\v1\User;
use App\Service\AbstractRestService;
use App\Repository\v1\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ClientService extends AbstractRestService {
    private $repo;

    public function __construct(
        ClientRepository $repo
    ) {
        $this->repo = $repo;
    }

    public function showAllUsers(string $slug, User $user): array {
        $client = $this->repo->findOneBy(['slug' => $slug]);
        
        if ($client !== null) {
            $isCurrentUserFromClient = $this->isUserFromClient($client->getSlug(), $user);

            if ($isCurrentUserFromClient) {
                return [
                    'status' => Response::HTTP_OK,
                    'data' => $client->jsonSerialize()
                ];
            } else {
                return [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not allowed to get users from this client'
                ];
            }
        } else {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Client not found'
            ];
        }
    }

    public function findOneBy(array $criteria) {
        return $this->repo->findOneBy($criteria);
    }
}