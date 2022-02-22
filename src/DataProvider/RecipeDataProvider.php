<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\ItemDataProvider;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;

class RecipeDataProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private $collectionDataProvider;
    private $recipeRepository;

    public function __construct(CollectionDataProviderInterface $collectionDataProvider, RecipeRepository $recipeRepository)
    {
        $this->collectionDataProvider = $collectionDataProvider;
        $this->recipeRepository = $recipeRepository;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $recipes = $this->recipeRepository->findAll();

        foreach ($recipes as $recipe)
        {
            //Récupère les potions de la recette
            $potions = $recipe->getPotions();
            //Calcule la valeur moyenne de la recette
            $average = $this->averageCalc($potions);
            //Ajoute la valeur moyenne à la recette
            $recipe->setAverageValue($average);
        }

        //Renvoie la liste des recettes avec leur valeur moyenne
        return $recipes;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Recipe
    {
        $recipe = $this->recipeRepository->find($id);

        $potions = $recipe->getPotions();
        $average = $this->averageCalc($potions);
        $recipe->setAverageValue($average);

        return $recipe;
    }

    private function averageCalc($potions): string
    {
        $values = [];
        foreach ($potions as $potion)
        {
            if($potion->getValue()) {
                $values[] = $potion->getValue();
            }
        }
        return array_sum($values) / count($values);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Recipe::class === $resourceClass;
    }
}
