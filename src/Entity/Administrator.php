<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AdminController;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdministratorRepository;

/**
 * @ORM\Entity(repositoryClass=AdministratorRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['controller' => adminController::class],
    ],
    itemOperations: [
        'patch',
        'delete',
        'get',
    ],
    attributes: ["security" => "is_granted('ROLE_ADMIN')"],
    ),
    ApiFilter(SearchFilter::class,
        properties: ['email' => 'exact', 'status' => 'exact']),
    ApiFilter(OrderFilter::class,
        properties: ['email', 'status', 'created_at', 'updated_at', 'token_password'],
        arguments: ['orderParameterName' => 'order']
    )
]
class Administrator extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;
}
