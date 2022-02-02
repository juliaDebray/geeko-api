<?php

namespace App\DataFixtures;

use App\Constants\Constant;
use App\Entity\Administrator;
use App\Entity\Customer;
use App\Entity\Ingredient;
use App\Entity\IngredientType;
use App\Entity\PotionType;
use App\Entity\Tool;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function load(ObjectManager $manager)
    {
        // Créer un outil d'alchimie activé
        $tool = new Tool();

        $tool
            ->setImage('default')
            ->setName('Cornue')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $manager->persist($tool);

        // Créer un outil d'alchimie désactivé
        $tool = new Tool();

        $tool
            ->setImage('default')
            ->setName('Alambic')
            ->setStatus(Constant::STATUS_DISABLED);

        $manager->persist($tool);

        // Créer un administrateur activé
        $admin = new Administrator();

        $admin
            ->setEmail('admin@example.com')
            ->setPassword('Pa$$w0rd')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $admin = $this->userService->makeUser($admin, Constant::ROLE_ADMIN);

        $manager->persist($admin);

        // Créer un administrateur désactivé
        $adminDisabled = new Administrator();

        $adminDisabled
            ->setEmail('admin@example.com')
            ->setPassword('Pa$$w0rd')
            ->setStatus(Constant::STATUS_DISABLED);

        $adminDisabled = $this->userService->makeUser($adminDisabled, Constant::ROLE_ADMIN);

        $manager->persist($adminDisabled);

        // Créer un utilisateur activé
        $customer = new Customer();

        $customer
            ->setEmail('user@example.com')
            ->setPassword('Pa$$w0rd')
            ->setAlchemistLevel('1')
            ->setPseudo('user')
            ->setAlchemistTool($tool)
            ->setStatus(Constant::STATUS_PENDING);

        $customer = $this->userService->makeUser($customer, Constant::ROLE_CUSTOMER);

        $manager->persist($customer);

        // Créer un utilisateur désactivé
        $customerDisabled = new Customer();

        $customerDisabled
            ->setEmail('desabledUser@example.com')
            ->setPassword('Pa$$w0rd')
            ->setAlchemistLevel('1')
            ->setPseudo('desabledUser')
            ->setAlchemistTool($tool)
            ->setStatus(Constant::STATUS_DISABLED);

        $customerDisabled = $this->userService->makeUser($customerDisabled, Constant::ROLE_CUSTOMER);

        $manager->persist($customerDisabled);

        // Envoie les données en base de données
        $manager->flush();
    }
}
