<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateCustomerController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Customer $data): Customer
    {
        return $this->userService->makePasswordHash($data);
    }
}
