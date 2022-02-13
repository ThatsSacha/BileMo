<?php

namespace App\Controller\v1;

use App\Entity\v1\User;
use App\Service\v1\UserService;
use App\Repository\v1\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/v1/user')]
class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): never
    {
        //
    }

    #[Route('', name: 'user_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }
        
        $create = $this->userService->new($data, $this->getUser());

        return new JsonResponse($create, $create['status']);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): never
    {
        //
    }

    #[Route('/{id}', name: 'user_edit', methods: ['PUT'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): never
    {
       //
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): never
    {
        //
    }
}
