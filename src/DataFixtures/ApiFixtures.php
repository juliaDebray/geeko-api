<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Customer;
use App\Entity\Ingredient;
use App\Entity\IngredientType;
use App\Entity\PotionType;
use App\Entity\Tool;
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
            ->setPassword('Pa$$w0rd');

        $admin = $this->userService->makeUser($admin, ['ROLE_ADMIN'], 'validated');

        $manager->persist($admin);

        /** Créer un outil d'alchimie */
        $tool = new Tool();

        $tool
            ->setImage('default')
            ->setName('Cornue');

        $manager->persist($tool);

        /** Créer un utilisateur */
        $customer = new Customer();

        $customer
            ->setEmail('ayamoure@example.com')
            ->setPassword('Pa$$w0rd')
            ->setAlchemistLevel('1')
            ->setPseudo('ayamoure')
            ->setAlchemistTool($tool);

        $customer = $this->userService->makeUser($customer, ['ROLE_CUSTOMER'], 'validated');

        $manager->persist($customer);

        /** Créer un type d'ingrédient */
        $ingredientType = new IngredientType();

        $ingredientType
            ->setName('champignon');

        $manager->persist($ingredientType);

        /** Créer 5 ingrédients */
        for ($i = 0; $i < 5; $i++)
        {
            $ingredient = new Ingredient();
            $ingredient->setName('ingredient' . $i+1);
            $ingredient->setImage('default');
            $ingredient->setType($ingredientType);
            $manager->persist($ingredient);
        }

        /** Créer un type de potion */
        $potionType = new PotionType();

        $potionType
            ->setName('soin')
            ->setImage('default');

        $manager->persist($potionType);

        /** Envoie les données en base de données */
        $manager->flush();
    }
}
