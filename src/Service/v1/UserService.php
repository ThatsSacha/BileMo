<?php

namespace App\Service\v1;

use App\Entity\v1\User;
use App\Service\v1\ClientService;
use App\Service\AbstractRestService;
use App\Repository\v1\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AbstractRestService {
    private ClientService $clientService;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        ClientService $clientService,
        UserPasswordHasherInterface $passwordHasher,
        DenormalizerInterface $denormalizer,
        UserRepository $repo,
        EntityManagerInterface $emi,
    ) {
        $this->clientService = $clientService;
        $this->passwordHasher = $passwordHasher;

        parent::__construct($denormalizer, $repo, $emi);
    }

    /**
     * @param array $data
     * @param User $user
     * 
     * @return array
     */
    public function new(array $data, User $user): array {
        $mandatoryFields = ['firstName', 'lastName', 'email', 'password', 'client'];
        $missingFields = $this->getMissingFields($data, $mandatoryFields);

        if (!$missingFields) {
            $blankValues = $this->getBlankValue($data);

            if (!$blankValues) {
                $isMailValid = $this->isMailValid($data['email']);

                if ($isMailValid) {
                    $client = $this->clientService->findOneBy(['slug' => $data['client']]);
                    
                    if ($client !== null) {
                        // Prevent a user to add a new user on a different client than himself
                        $isCurrentUserFromClient = $this->isUserFromClient($client->getSlug(), $user);
                        
                        if ($isCurrentUserFromClient) {
                            $userExists = $this->isUserAlreadyExistsInClient($client->getUsers(), $data['email']);

                            if (!$userExists) {
                                $userObject = $this->hydrate($data);
                                $hashedPassword = $this->passwordHasher->hashPassword($userObject, $data['password']);

                                $userObject->setClient($client)
                                            ->setPassword($hashedPassword);
                               
                                $this->create($userObject);
                                
                                return [
                                    'status' => Response::HTTP_CREATED,
                                    'user' => $userObject->jsonSerialize()
                                ];
                            } else {
                                return [
                                    'status' => Response::HTTP_BAD_REQUEST,
                                    'message' => 'User already exists for this client'
                                ];
                            }
                        } else {
                            return [
                                'status' => Response::HTTP_FORBIDDEN,
                                'message' => 'You are not allowed to create a user for this client'
                            ];
                        }
                    } else {
                        return [
                            'status' => Response::HTTP_NOT_FOUND,
                            'message' => 'Client not found'
                        ];
                    }
                } else {
                    return [
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => 'The email format is not valid'
                    ];
                }
            } else {
                return [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Fields cannot be blank: ' . implode(', ', $blankValues)
                ];
            }
        } else {
            return [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Missing fields: ' . implode(', ', $missingFields)
            ];
        }
    }

    /**
     * @param int $id
     * @param User $user
     * 
     * @return array
     */
    public function deleteUser(int $id, User $user): array {
        $userToDelete = $this->findOneBy(['id' => $id]);

        if ($userToDelete !== null) {
            if ($userToDelete->getEmail() !== $user->getEmail()) {
                // Prevent a user to delete a user on a different client than himself
                $isCurrentUserFromClient = $this->isUserFromClient($userToDelete->getClient()->getSlug(), $user);

                if ($isCurrentUserFromClient) {
                    $this->delete($userToDelete);

                    return [
                        'status' => Response::HTTP_OK,
                        'message' => 'User deleted'
                    ];
                } else {
                    return [
                        'status' => Response::HTTP_FORBIDDEN,
                        'message' => 'You are not allowed to delete a user for this client'
                    ];
                }
            } else {
                return [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You cannot delete yourself'
                ];
            }
        } else {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found'
            ];
        }
    }

    /**
     * @param int $id
     * @param User $user
     * 
     * @return array
     */
    public function show(int $id, User $user): array {
        $userToShow = $this->findOneBy(['id' => $id]);

        if ($userToShow !== null) {
            // Prevent a user to show a user on a different client than himself
            $isCurrentUserFromClient = $this->isUserFromClient($userToShow->getClient()->getSlug(), $user);

            if ($isCurrentUserFromClient) {
                return [
                    'status' => Response::HTTP_OK,
                    'user' => $userToShow->jsonSerialize()
                ];
            } else {
                return [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not allowed to show a user for this client'
                ];
            }
        } else {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found'
            ];
        }
    }

    /**
     * @param Collection $client
     * @param string $mail The email of the user to check
     * 
     * @return bool
     */
    public function isUserAlreadyExistsInClient(Collection $client, string $mail): bool {
        $clientUsers = [];

        foreach ($client as $clientUser) {
            $clientUsers[$clientUser->getEmail()] = $clientUser;
        }

        return in_array($mail, array_keys($clientUsers));
    }
}