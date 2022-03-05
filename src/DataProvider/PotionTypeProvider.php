<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\PotionType;
use App\Exception\PotionTypeNotFoundException;
use App\Repository\PotionTypeRepository;
use Symfony\Component\Security\Core\Security;
use App\Constants\Constant;
use App\Constants\ErrorMessage;

class PotionTypeProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{

    private $collectionDataProvider;
    private $potionTypeRepository;
    private $security;

    public function __construct(CollectionDataProviderInterface $collectionDataProvider,
                                PotionTypeRepository $potionTypeRepository, Security $security)
    {
        $this->collectionDataProvider = $collectionDataProvider;
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

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();
        $potionType = $this->potionTypeRepository->find($id);

        if ($user && $user->getRoles() === Constant::ROLE_ADMIN) {
            return $potionType;
        }

        if ($potionType->getStatus() === Constant::STATUS_DISABLED) {
            return throw new PotionTypeNotFoundException(ErrorMessage::POTION_TYPE_NOT_FOUND);
        }

        return $potionType;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return PotionType::class === $resourceClass;
    }
}
