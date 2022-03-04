<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Tool;
use App\Repository\ToolRepository;
use Symfony\Component\Security\Core\Security;
use App\Constants\Constant;
use App\Constants\ErrorMessage;
use App\Exception\ToolNotFoundException;
use Exception;

class ToolProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{

    private $collectionDataProvider;
    private  $toolRepository;
    private $security;

    public function __construct(CollectionDataProviderInterface $collectionDataProvider, ToolRepository $toolRepository, Security $security)
    {
        $this->collectionDataProvider = $collectionDataProvider;
        $this->toolRepository = $toolRepository;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();

        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return $this->toolRepository->findAll();
        }

        return $this->toolRepository->findToolsByStatus(Constant::STATUS_ACTIVATED);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();
        $tool = $this->toolRepository->find($id);

        if ($user && $user->getRoles() === Constant::ROLE_ADMIN) {
            return $tool;
        }

        if ($tool->getStatus() === Constant::STATUS_DISABLED) {
            return throw new ToolNotFoundException(ErrorMessage::TOOL_NOT_FOUND);
        }

        return $tool;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Tool::class === $resourceClass;
    }
}
