<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Component\Security\Core\Security;
use App\Constants\Constant;
use App\Constants\ErrorMessage;
use App\Exception\ToolNotFoundException;

class IngredientProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private IngredientRepository $ingredientRepository;
    private Security $security;

    public function __construct(IngredientRepository $ingredientRepository, Security $security)
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();

        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return $this->ingredientRepository->findAll();
        }

        return $this->ingredientRepository->findByStatus(Constant::STATUS_ACTIVATED);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): Ingredient|null
    {
        $user = $this->security->getUser();
        $ingredient = $this->ingredientRepository->find($id);

        if ($user && $user->getRoles() === Constant::ROLE_ADMIN) {
            return $ingredient;
        }

        if ($ingredient->getStatus() === Constant::STATUS_DISABLED) {
            return throw new ToolNotFoundException(ErrorMessage::INGREDIENT_NOT_FOUND);
        }

        return $ingredient;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Ingredient::class === $resourceClass;
    }
}
