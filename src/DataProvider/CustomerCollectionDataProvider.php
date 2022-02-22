<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\CollectionDataProvider;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Constants\Constant;
use Symfony\Component\Security\Core\Security;

final class CustomerCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    private $collectionDataProvider;
    private $customerRepository;
    private $security;

    public function __construct(CustomerRepository $customerRepository, CollectionDataProviderInterface $collectionDataProvider, Security $security)
    {
        $this->collectionDataProvider = $collectionDataProvider;
        $this->customerRepository = $customerRepository;
        $this->security = $security;
    }

    // Exécute un getAll sur Customer selon le role de l'utilisateur
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();
        $data = $this->customerRepository->findAll();

        // Si l'utilisateur est un admin, renvoie toutes les données des customers
        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return  $data;
        }

        // Sinon, ne renvoie que les données non sensibles
        foreach ($data as $customer)
        {
            $customer
                ->setEmail("hidden@anonymous.com")
                ->setStatus("hidden")
                ->setPassword("hidden")
                ->setCreatedAt("hidden")
                ->setUpdatedAt("hidden")
                ->setTokenPassword("hidden");
        }
        return $data;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Customer::class === $resourceClass;
    }
}
