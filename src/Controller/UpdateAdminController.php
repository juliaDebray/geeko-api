<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateAdminController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Administrator $data): Administrator
    {
        return $this->userService->makePasswordHash($data);
    }
}
