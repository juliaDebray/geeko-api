<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 * @UniqueEntity("name", message="ce nom existe déjà")
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security' => "is_granted('ROLE_ADMIN')"],
    ],
    itemOperations: [
        'get',
        'delete' => ['security' => "is_granted('ROLE_ADMIN')"],
        'patch' => ['security' => "is_granted('ROLE_ADMIN')"],
    ],
    denormalizationContext: ['groups' => ['write:item']],
    normalizationContext: ['groups' => ['read:item']]
)]

class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:item'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le nom ne peut pas faire plus de {{ limit }} caractères."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas du type {{ type }}")"
     */
    #[Groups(['read:item', 'write:item'])]
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le nom de l'image ne peut pas faire plus de {{ limit }} caractères."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas du type {{ type }}")"
     */
    #[Groups(['read:item', 'write:item'])]
    private string $image;

    /**
     * @ORM\ManyToOne(targetEntity=IngredientType::class, inversedBy="ingredients")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    #[Groups(['read:item', 'write:item'])]
    private IngredientType $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?IngredientType
    {
        return $this->type;
    }

    public function setType(?IngredientType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
