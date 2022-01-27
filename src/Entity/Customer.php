<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\CustomerController;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ApiResource(
        collectionOperations: [
          'get',
          'post' => ['controller' => CustomerController::class],
        ],
        itemOperations: [
            'patch',
            'delete',
            'get',
        ],
        denormalizationContext: ['groups' => ['write:item']],
        normalizationContext: ['groups' => ['read:item', 'read:Tool', 'read:Potion']]
    ),
    ApiFilter(SearchFilter::class, properties: ['email' => 'exact', 'status' => 'exact']),
    ApiFilter(OrderFilter::class, properties: ['pseudo', 'alchemist_level', 'alchemist_tool', 'email', 'status', 'created_at', 'updated_at', 'token_password'], arguments: ['orderParameterName' => 'order'])
]
/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @UniqueEntity("pseudo", message="ce pseudo existe déjà")
 */
class Customer extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    #[Groups(['read:item', 'write:item'])]
    private string $pseudo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     */
    #[Groups(['read:item', 'write:item'])]
    private int $alchemistLevel;

    /**
     * @ORM\OneToMany(targetEntity=Potion::class, mappedBy="customer")
     */
    private Collection $potions;

    /**
     * @ORM\ManyToOne(targetEntity=Tool::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:item', 'write:item', 'read:Tool'])]
    private Tool $alchemistTool;

    public function __construct()
    {
        parent::__construct();
        $this->potions = new ArrayCollection();
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
            $potion->setCustomer($this);
        }

        return $this;
    }

    public function removePotion(Potion $potion): self
    {
        if ($this->potions->removeElement($potion)) {
            // set the owning side to null (unless already changed)
            if ($potion->getCustomer() === $this) {
                $potion->setCustomer(null);
            }
        }

        return $this;
    }

    public function getAlchemistTool(): ?Tool
    {
        return $this->alchemistTool;
    }

    public function setAlchemistTool(?Tool $alchemistTool): self
    {
        $this->alchemistTool = $alchemistTool;

        return $this;
    }
}
