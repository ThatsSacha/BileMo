<?php

namespace App\Service\v1;

use App\Entity\v1\User;
use App\Service\AbstractRestService;
use App\Repository\v1\ClientRepository;
use App\Repository\v1\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class ClientService extends AbstractRestService {
    private $repo;
    private UserRepository $userRepo;

    public function __construct(
        ClientRepository $repo,
        UserRepository $userRepo
    ) {
        $this->repo = $repo;
        $this->userRepo = $userRepo;
    }

    /**
     * @param string $slug
     * @param User $user
     * 
     * @return array
     */
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

    /**
     * @param string $slug
     * @param int $id The user to search
     * @param User $user
     * 
     * @return array
     */
    public function showDetailUser(string $slug, int $id, User $user): array {
        $client = $this->repo->findOneBy(['slug' => $slug]);
        
        if ($client !== null) {
            $isCurrentUserFromClient = $this->isUserFromClient($client->getSlug(), $user);

            if ($isCurrentUserFromClient) {
                $userToSearch = $this->userRepo->findOneBy(['id' => $id]);

                if ($userToSearch !== null) {
                    $isCurrentUserFromClient = $this->isUserFromClient($userToSearch->getClient()->getSlug(), $user);

                    if ($isCurrentUserFromClient) {
                        return [
                            'status' => Response::HTTP_OK,
                            'data' => $userToSearch->jsonSerialize()
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
                        'message' => 'User not found'
                    ];
                }
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