<?php

namespace App\Service;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerService extends AbstractController
{
    public function makeCustomer(Customer $customer, UserPasswordHasherInterface $passwordHasher)
    {
        $customer->setRoles(['ROLE_CUSTOMER']);
        $customer->setStatus('pending');
        $customer->setPassword
        (
            $passwordHasher->hashPassword( $customer, $customer->getPassword() )
        );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($customer);
        $entityManager->flush();
    }
}
