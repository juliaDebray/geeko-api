<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PotionRepository::class)
 */
#[ApiResource]
class Potion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="potions")
     * @ORM\JoinColumn(nullable=false)
     */
    private Customer $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="potions")
     * @ORM\JoinColumn(nullable=false)
     */
    private Recipe $recipe;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private string $value;

    /**
     * @ORM\ManyToOne(targetEntity=PotionType::class, inversedBy="potions")
     * @ORM\JoinColumn(nullable=false)
     */
    private PotionType $type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?PotionType
    {
        return $this->type;
    }

    public function setType(?PotionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
