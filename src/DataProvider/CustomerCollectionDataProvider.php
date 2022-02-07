<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Constants\Constant;
use Symfony\Component\Security\Core\Security;

final class CustomerCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    public $customerRepository;
    public $security;

    public function __construct(CustomerRepository $customerRepository, Security $security)
    {
        $this->customerRepository = $customerRepository;
        $this->security = $security;
    }

    // Exécute un getAll sur Customer selon le role de l'utilisateur
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser();

        // Si l'utilisateur est un admin, renvoie toutes les données des customers
        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return  $this->customerRepository->findAll();
        }

        // Sinon, ne renvoie que les données non sensibles
        return $this->customerRepository->getCustomerWithoutBeeingAdmin();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Customer::class === $resourceClass;
    }
}
