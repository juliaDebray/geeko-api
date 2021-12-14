<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    private $alchemistLevel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    private $alchemistTool;

    public function __construct()
    {
        $this->Id = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAlchemistLevel(): ?int
    {
        return $this->alchemistLevel;
    }

    public function setAlchemistLevel(int $alchemistLevel): self
    {
        $this->alchemistLevel = $alchemistLevel;

        return $this;
    }

    public function getAlchemistTool(): ?string
    {
        return $this->alchemistTool;
    }

    public function setAlchemistTool(string $alchemistTool): self
    {
        $this->alchemistTool = $alchemistTool;

        return $this;
    }
}
