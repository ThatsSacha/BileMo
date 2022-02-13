<?php

namespace App\Controller\v1;

use App\Service\v1\UserService;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(int $id): JsonResponse
    {
        $show = $this->userService->show($id, $this->getUser());

        return new JsonResponse($show, $show['status']);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $delete = $this->userService->deleteUser($id, $this->getUser());

        return new JsonResponse($delete, $delete['status']);
    }
}
