<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\Persistence\ManagerRegistry;

class PotionService
{
    private RecipeRepository $recipeRepository;
    private ManagerRegistry $entityManager;
    private StatusService $statusService;

    public function __construct(RecipeRepository $recipeRepository,
                                ManagerRegistry $entityManager,
                                StatusService $statusService)
    {
        $this->recipeRepository = $recipeRepository;
        $this->entityManager = $entityManager;
        $this->statusService = $statusService;
    }

    public function makePotion($data, $user)
    {
        $data->setCustomer($user);
        $data->setCreatedAt(new \DateTime('now'));
        $this->statusService->addActivatedStatus($data);

        /** Récupère la recette envoyée par l'utilisateur sour la forme ['1','1','2'] */
        $dataIngredient = $data->getIngredientsList();

        /** Récupère toutes les recettes sous la forme [Recipe{},Recipe{},Recipe{}]*/
        $currentRecipes = $this->recipeRepository->findAll();

        /** Compare la recette de l'utilisateur et les recettes enregistrées */
        foreach($currentRecipes as $recipe)
        {
            /** Si la recette existe, lie la potion ajoutée à celle-ci */
            if($dataIngredient === $recipe->getIngredientsList())
            {
                $data->setRecipe($recipe);

                return $data;
            }
        }

        /** Si la recette n'existe pas, la créer */
        $newRecipe = $this->makeRecipe($dataIngredient, $data);

        /** Lie la potion à la recette nouvellement créée */
        $data->setRecipe($newRecipe);
    }

    /** retourne la nouvelle recette */
    public function makeRecipe($Ingredients, $data): Recipe
    {
        $newRecipe = new Recipe();
        $newRecipe->setIngredientsList($Ingredients);
        $newRecipe->setType($data->getType()->getId());
        $this->statusService->addActivatedStatus($data);

        /** Envoie la nouvelle recette en base de données */
        $entityManager = $this->entityManager->getManager();
        $entityManager->persist($newRecipe);
        $entityManager->flush($newRecipe);

        return $newRecipe;
    }
}
