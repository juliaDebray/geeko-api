<?php

namespace App\Service;

use App\Entity\Administrator;
use App\Entity\Customer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function makeUser(Customer | Administrator $data, $role, $status): Customer | Administrator
    {
        $data->setRoles($role);
        $data->setStatus($status);
        $this->makePasswordHash($data);
        $data->setCreatedAt(new DateTime('now'));

        return $data;
    }

    public function makePasswordHash(Customer | Administrator $data): Customer | Administrator
    {

        $data->setPassword
        (
            $this->passwordHasher->hashPassword( $data, $data->getPassword() )
        );

        $this->updateUser($data);

        return $data;
    }

    public function updateUser(Customer | Administrator $data): Customer | Administrator
    {
        $data->setUpdatedAt(new DateTime('now'));

        return $data;
    }
}
