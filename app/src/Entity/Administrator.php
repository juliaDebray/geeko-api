<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ApiResource(
 *
 * )
 * @ORM\Entity(repositoryClass=AdministratorRepository::class)
 */
class Administrator
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    public function __construct()
    {
        $this->Id = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
