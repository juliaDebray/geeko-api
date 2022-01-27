<?php

namespace App\Service;

use App\Entity\User;
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

    public function makeUser(User $data, $role, $status): User
    {
        $data->setRoles($role);
        $data->setStatus($status);
        $this->makePasswordHash($data);
        $data->setCreatedAt(new DateTime('now'));

        return $data;
    }

    public function makePasswordHash(User $data): User
    {

        $data->setPassword
        (
            $this->passwordHasher->hashPassword( $data, $data->getPassword() )
        );

        $this->updateUser($data);

        return $data;
    }

    public function updateUser(User $data): User
    {
        $data->setUpdatedAt(new DateTime('now'));

        return $data;
    }
}
