<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ToolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ToolRepository::class)
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
class Tool
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:item', 'read:Tool'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     * @Assert\Length(
     *     max = 50,
     *     maxMessage = "Le nom ne peut pas faire plus de {{ limit }} caractères."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas du type {{ type }}"
     * )
     */
    #[Groups(['read:item', 'read:Tool', 'write:item'])]
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est recquis")
     * @Assert\NotNull(message="ce champ est recquis")
     * @Assert\Length(
     *     max = 50,
     *     maxMessage = "Le nom ne peut pas faire plus de {{ limit }} caractères."
     * )
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas du type {{ type }}"
     * )
     */
    #[Groups(['read:item', 'read:Tool', 'write:item'])]
    private string $image;

    /**
     * @ORM\OneToMany(targetEntity=Customer::class, mappedBy="alchemistTool")
     */
    private Collection $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
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

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setAlchemistTool($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getAlchemistTool() === $this) {
                $customer->setAlchemistTool(null);
            }
        }

        return $this;
    }
}
