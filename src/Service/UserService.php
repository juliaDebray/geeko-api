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

        /**
         * Vérifie si le mot de passe répond aux exigences de la regex et s'il est non null et non vide.
         * Sinon, le mot de passe n'est pas hashé et les contraintes de validator bloqueront l'entrée de la donnée.
         */
        if ($data->getPassword()
            && preg_match('/^(?=.*\W)(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/',$data->getPassword())
            && !empty($data->getPassword())) {
            $data->setPassword
            (
                $this->passwordHasher->hashPassword($data, $data->getPassword())
            );
        }

        $this->updateUser($data);

        return $data;
    }

    public function updateUser(User $data): User
    {
        $data->setUpdatedAt(new DateTime('now'));

        return $data;
    }
}
