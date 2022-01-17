<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PotionController;
use App\Repository\PotionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PotionRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'controller' => PotionController::class,
            'security' => "is_granted('ROLE_CUSTOMER')",
        ],
    ],
    itemOperations: [
        'get',
        'delete' => ['security' => "is_granted('ROLE_ADMIN')"],
        'patch' => [
            'security' => "is_granted('ROLE_ADMIN')",
            'normalization_context' => ['groups' => ['modify']],
        ],
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']]

)]

class Potion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups('read')]
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="potions")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read'])]
    private Customer $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="potions")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read', 'modify'])]
    private Recipe $recipe;

    /**
     * @ORM\Column(type="string", length=4)
     */
    #[Groups(['read', 'write', 'modify'])]
    private string $value;

    /**
     * @ORM\ManyToOne(targetEntity=PotionType::class, inversedBy="potions")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read', 'write', 'modify'])]
    private PotionType $type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    #[Groups(['read'])]
    private $created_at;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    #[Groups(['write'])]
    private array $ingredientsList = [];

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

    public function getIngredientsList(): ?array
    {
        return $this->ingredientsList;
    }

    public function setIngredientsList(?array $ingredientsList): self
    {
        $this->ingredientsList = $ingredientsList;

        return $this;
    }
}
