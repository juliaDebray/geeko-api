<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Constants\InvalidMessage;
use App\Controller\AddActivatedStatusController;
use App\Controller\DeleteController;
use App\Repository\PotionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PotionTypeRepository::class)
 * @UniqueEntity("name", message="ce nom existe déjà")
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security' => "is_granted('ROLE_ADMIN')",
            'controller' => AddActivatedStatusController::class
        ],
    ],
    itemOperations: [
        'get',
        'delete' => [
            'security' => "is_granted('ROLE_ADMIN')",
            'controller' => DeleteController::class
        ],
        'patch' => ['security' => "is_granted('ROLE_ADMIN')"],
    ],
    denormalizationContext: ['groups' => ['write:item']],
    normalizationContext: ['groups' => ['read:item']]
)]
class PotionType
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
     */
    #[Assert\Length(max: 255, maxMessage: InvalidMessage::MAX_MESSAGE)]
    #[Assert\Type(type: "string", message: InvalidMessage::BAD_TYPE)]
    #[Assert\NotBlank(message: InvalidMessage::NOT_BLANK)]
    #[Assert\NotNull(message: InvalidMessage::NOT_NULL)]
    #[Groups(['read:item', 'write:item'])]
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\Length(max: 255, maxMessage: InvalidMessage::MAX_MESSAGE)]
    #[Assert\Type(type: "string", message: InvalidMessage::BAD_TYPE)]
    #[Assert\NotBlank(message: InvalidMessage::NOT_BLANK)]
    #[Assert\NotNull(message: InvalidMessage::NOT_NULL)]
    #[Groups(['read:item', 'write:item'])]
    private string $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Assert\Length(max: 255, maxMessage: InvalidMessage::MAX_MESSAGE)]
    #[Assert\Type(type: "string", message: InvalidMessage::BAD_TYPE)]
    #[Groups(['read:item', 'write:item'])]
    private string $description;

    /**
     * @ORM\OneToMany(targetEntity=Potion::class, mappedBy="type")
     */
    private Collection $potions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
