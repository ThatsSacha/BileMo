<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/client')]
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
