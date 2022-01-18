<?php

namespace App\DataFixtures;


use App\Entity\Administrator;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApiFixtures extends Fixture
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Administrator();

        $admin
            ->setEmail('admin@example.com')
            ->setPassword('Pa$$w0rd');

        $admin = $this->userService->makeUser($admin, ['ROLE_ADMIN'], 'validated');

        $manager->persist($admin);
        $manager->flush();
    }
}
