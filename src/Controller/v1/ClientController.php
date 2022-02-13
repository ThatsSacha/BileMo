<?php

namespace App\Controller√v1;

use App\Entity\v1\Client;
use App\Entity\v1\User;
use App\Repository\v1\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/v1/api/client')]
class ClientController extends AbstractController
{
    #[Route('', name: 'client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): never
    {
       //
    }

    #[Route('', name: 'client_new', methods: ['POST'])]
    public function new(Request $request): never
    {
        //
    }

    #[Route('/{id}', name: 'client_show', methods: ['GET'])]
    public function show(Client $client): never
    {
        //
    }

    #[Route('/{id}', name: 'client_edit', methods: ['POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): never
    {
        //
    }

    #[Route('/{id}', name: 'client_delete', methods: ['DELETE'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): never
    {
        //
    }
}
