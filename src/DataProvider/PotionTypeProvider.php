<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\PotionType;
use App\Exception\PotionTypeNotFoundException;
use App\Repository\PotionTypeRepository;
use Symfony\Component\Security\Core\Security;
use App\Constants\Constant;

class PotionTypeProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{
    private PotionTypeRepository $potionTypeRepository;
    private Security $security;

    public function __construct(PotionTypeRepository $potionTypeRepository, Security $security)
    {
        $this->potionTypeRepository = $potionTypeRepository;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();

        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return $this->potionTypeRepository->findAll();
        }

        return $this->potionTypeRepository->findByStatus(Constant::STATUS_ACTIVATED);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): PotionType|null
    {
        $potionType = $this->potionTypeRepository->find($id);

        if(!$potionType)
        {
            throw new PotionTypeNotFoundException();
        }

        $user = $this->security->getUser();

        if ($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return $potionType;
        }

        if ($potionType->getStatus() === Constant::STATUS_DISABLED)
        {
            throw new PotionTypeNotFoundException();
        }

        return $potionType;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return PotionType::class === $resourceClass;
    }
}
