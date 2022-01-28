<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Constants\Constant;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Customer $data): User
    {
        $data->setStatus(Constant::STATUS_PENDING);
        return $this->userService->makeUser($data, Constant::ROLE_CUSTOMER);
    }
}
