<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateUserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Le type de $data doit être User.
     * Le typage Cutomer | Administrator ne fonctionne pas sur l'argument cette méthode.
     */
    public function __invoke(User $data): User
    {
        return $this->userService->makePasswordHash($data);
    }
}
