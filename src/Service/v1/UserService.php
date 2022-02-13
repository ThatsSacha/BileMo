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
                        $isCurrentUserFromClient = $client->getSlug() === $user->getClient()->getSlug();
                        
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