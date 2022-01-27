<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Service\StatusService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    private UserService $userService;
    private StatusService $statusService;

    public function __construct(UserService $userService, StatusService $statusService)
    {
        $this->userService = $userService;
        $this->statusService = $statusService;
    }

    public function __invoke(Customer $data): User
    {
        return $this->userService->makeUser(
            $this->statusService->addPendingStatus($data), ["ROLE_CUSTOMER"]
        );
    }
}
