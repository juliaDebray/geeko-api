<?php

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Customer;
use App\Exception\CustomerNotFoundException;
use App\Repository\CustomerRepository;
use App\Constants\Constant;
use Symfony\Component\Security\Core\Security;

final class CustomerProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    private CustomerRepository $customerRepository;
    private Security $security;

    public function __construct(CustomerRepository $customerRepository, Security $security)
    {
        $this->customerRepository = $customerRepository;
        $this->security = $security;
    }

    private function setAnonymousData($customer): void
    {
        $customer
            ->setEmail("hidden@anonymous.com")
            ->setStatus("hidden")
            ->setPassword("hidden")
            ->setCreatedAt("hidden")
            ->setUpdatedAt("hidden")
            ->setTokenPassword("hidden");
    }

    // Exécute un getAll sur Customer selon le role de l'utilisateur
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $data = $this->customerRepository->findAll();

        if(!$data)
        {
            throw new CustomerNotFoundException();
        }

        $user = $this->security->getUser();

        // Si l'utilisateur est un admin, renvoie toutes les données des customers
        if($user && $user->getRoles() === Constant::ROLE_ADMIN)
        {
            return  $data;
        }

        // Sinon, ne renvoie que les données non sensibles
        foreach ($data as $customer)
        {
            $this->setAnonymousData($customer);
        }
        return $data;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Customer::class === $resourceClass;
    }
}
