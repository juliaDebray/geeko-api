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
        $data->setPassword
        (
            $this->passwordHasher->hashPassword( $data, $data->getPassword() )
        );
        $data->setCreatedAt(new DateTime('now'));
        $data->setUpdatedAt(new DateTime('now'));

        return $data;
    }
}
