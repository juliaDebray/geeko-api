<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Constants\Constant;
use App\Entity\Recipe;
use App\Exception\RecipeNotFoundException;
use App\Repository\RecipeRepository;
use Symfony\Component\Security\Core\Security;

class RecipeDataProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private RecipeRepository $recipeRepository;
    private Security $security;

    public function __construct(RecipeRepository $recipeRepository, Security $security)
    {
        $this->recipeRepository = $recipeRepository;
        $this->security = $security;
    }

    // Calcule la moyenne de la valeur d'une potion
    private function averageCalc($potions): string
    {
        $values = [];
        foreach ($potions as $potion)
        {
            if($potion->getValue()) {
                $values[] = $potion->getValue();
            }
        }

        return round(array_sum($values) / count($values));
    }

    private function setAverage(Recipe $recipe)
    {
        //Récupère les potions de la recette
        $potions = $recipe->getPotions();
        //Calcule la valeur moyenne de la recette
        $average = $this->averageCalc($potions);
        //Ajoute la valeur moyenne à la recette
        $recipe->setAverageValue($average);
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): array|null
    {
        $user = $this->security->getUser();

        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            $recipes = $this->recipeRepository->findAll();
        } else {
            $recipes = $this->recipeRepository->findByStatus(Constant::STATUS_ACTIVATED);
        }

        if(!$recipes)
        {
            throw new RecipeNotFoundException();
        }

        foreach ($recipes as $recipe)
        {
            $this->setAverage($recipe);
        }

        // Renvoie la liste des recettes avec leur valeur moyenne
        return $recipes;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Recipe
    {
        $recipe = $this->recipeRepository->find($id);

        if(!$recipe) {
            throw new RecipeNotFoundException();
        }

        $user = $this->security->getUser();

        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            $this->setAverage($recipe);
            return $recipe;
        }

        if($recipe->getStatus() === Constant::STATUS_DISABLED)
        {
            throw new RecipeNotFoundException();
        }

        $this->setAverage($recipe);

        return $recipe;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Recipe::class === $resourceClass;
    }
}
