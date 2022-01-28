<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Customer;
use App\Entity\Ingredient;
use App\Entity\IngredientType;
use App\Entity\PotionType;
use App\Entity\Tool;
use App\Constants\Constant;
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
        /** Créer un administrateur */
        $admin = new Administrator();

        $admin
            ->setEmail('admin@example.com')
            ->setPassword('Pa$$w0rd')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $admin = $this->userService->makeUser($admin, Constant::ROLE_ADMIN);

        $manager->persist($admin);

        /** Créer un outil d'alchimie */
        $tool = new Tool();

        $tool
            ->setImage('default')
            ->setName('Cornue')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $manager->persist($tool);

        /** Créer un utilisateur */
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

        /** Créer un type d'ingrédient */
        $ingredientType = new IngredientType();

        $ingredientType
            ->setName('champignon')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $manager->persist($ingredientType);

        /** Créer 5 ingrédients */
        for ($i = 0; $i < 5; $i++)
        {
            $ingredient = new Ingredient();
            $ingredient->setName('ingredient' . $i+1);
            $ingredient->setImage('default');
            $ingredient->setType($ingredientType);
            $ingredient->setStatus(Constant::STATUS_ACTIVATED);
            $manager->persist($ingredient);
        }

        /** Créer un type de potion */
        $potionType = new PotionType();

        $potionType
            ->setName('soin')
            ->setImage('default')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $manager->persist($potionType);

        /** Envoie les données en base de données */
        $manager->flush();
    }
}
