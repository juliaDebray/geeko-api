<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PotionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PotionTypeRepository::class)
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
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']]
)]
class PotionType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    #[Groups(['read', 'write'])]
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    #[Groups(['read', 'write'])]
    private string $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read', 'write'])]
    private string $description;

    /**
     * @ORM\OneToMany(targetEntity=Potion::class, mappedBy="type")
     */
    private $potions;

    public function __construct()
    {
        $this->potions = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Potion[]
     */
    public function getPotions(): Collection
    {
        return $this->potions;
    }

    public function addPotion(Potion $potion): self
    {
        if (!$this->potions->contains($potion)) {
            $this->potions[] = $potion;
            $potion->setType($this);
        }

        return $this;
    }

    public function removePotion(Potion $potion): self
    {
        if ($this->potions->removeElement($potion)) {
            // set the owning side to null (unless already changed)
            if ($potion->getType() === $this) {
                $potion->setType(null);
            }
        }

        return $this;
    }
}
