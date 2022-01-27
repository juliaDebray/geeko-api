<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Administrator $data): User
    {
        return $this->userService->makeUser($data, ["ROLE_ADMIN"], 'validated');
    }
}
