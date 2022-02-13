<?php

namespace App\Controller\v1;

use App\Entity\v1\Client;
use App\Service\v1\ClientService;
use App\Repository\v1\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/v1/client')]
class ClientController extends AbstractController
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    #[Route('/{slug}/user/all', name: 'client_show_user_all', methods: ['GET'])]
    public function show(string $slug): JsonResponse
    {
        $showAll = $this->clientService->showAllUsers($slug, $this->getUser());

        return new JsonResponse($showAll, $showAll['status']);
    }
}
