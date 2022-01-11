<?php

namespace App\Service;

use App\Entity\Customer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerService extends AbstractController
{
    public function makeCustomer(Customer $data, UserPasswordHasherInterface $passwordHasher)
    {
        $data->setRoles(['ROLE_CUSTOMER']);
        $data->setStatus('pending');
        $data->setPassword
        (
            $passwordHasher->hashPassword( $data, $data->getPassword() )
        );
        $data->setCreatedAt(new DateTime('now'));
        $data->setUpdatedAt(new DateTime('now'));

        return $data;
    }
}
