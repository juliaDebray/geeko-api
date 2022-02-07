<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Constants\Constant;

final class CustomerCollectionDataProvider extends AbstractController implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    public $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    // Exécute un getAll sur Customer selon le role de l'utilisateur
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $user = $this->getUser();

        // Si l'utilisateur est un admin, renvoie toutes les données des customers
        if($user && $user->getRoles() === Constant::ROLE_ADMIN) {
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
