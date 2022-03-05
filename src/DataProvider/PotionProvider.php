<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Potion;
use App\Exception\PotionNotFoundException;
use App\Repository\PotionRepository;
use Symfony\Component\Security\Core\Security;
use App\Constants\Constant;
use App\Constants\ErrorMessage;

class PotionProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private PotionRepository $potionRepository;
    private Security $security;

    public function __construct(PotionRepository $potionRepository, Security $security)
    {
        $this->potionRepository = $potionRepository;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();

        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return $this->potionRepository->findAll();
        }

        return $this->potionRepository->findByStatus(Constant::STATUS_ACTIVATED);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();
        $potion = $this->potionRepository->find($id);

        if(!$potion) {
            return throw new PotionNotFoundException(ErrorMessage::POTION_NOT_FOUND);
        }

        if ($user && $user->getRoles() === Constant::ROLE_ADMIN) {
            return $potion;
        }

        if ($potion && $potion->getStatus() === Constant::STATUS_DISABLED) {
            return throw new PotionNotFoundException(ErrorMessage::POTION_NOT_FOUND);
        }

        return $potion;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Potion::class === $resourceClass;
    }
}
