<?php

namespace App\DataFixtures;

use App\Constants\Constant;
use App\Entity\Ingredient;
use App\Entity\IngredientType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer un type d'ingrédient activé
        $ingredientType = new IngredientType();

        $ingredientType
            ->setName('champignon')
            ->setStatus(Constant::STATUS_ACTIVATED);

        $manager->persist($ingredientType);

        // Créer un type d'ingrédient désactivé
        $ingredientTypeDisabled = new IngredientType();

        $ingredientTypeDisabled
            ->setName('Fleur')
            ->setStatus(Constant::STATUS_DISABLED);

        $manager->persist($ingredientTypeDisabled);

        // Créer 5 ingrédients activés
        for ($i = 0; $i < 5; $i++)
        {
            $ingredient = new Ingredient();
            $ingredient->setName('ingredient' . $i+1);
            $ingredient->setImage('default');
            $ingredient->setType($ingredientType);
            $ingredient->setStatus(Constant::STATUS_ACTIVATED);

            $manager->persist($ingredient);
        }

        // Créer 5 ingrédients désactivés
        for ($i = 0; $i < 5; $i++)
        {
            $ingredientDisabled = new Ingredient();
            $ingredientDisabled->setName('ingredientDisabled' . $i+1);
            $ingredientDisabled->setImage('default');
            $ingredientDisabled->setType($ingredientTypeDisabled);
            $ingredientDisabled->setStatus(Constant::STATUS_DISABLED);

            $manager->persist($ingredientDisabled);
        }

        // Envoie les données en base de données
        $manager->flush();
    }
}
