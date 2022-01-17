<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
#[ApiResource]
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity=Potion::class, mappedBy="recipe")
     */
    private Collection $potions;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private array $ingredientsList = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $averageValue;

    public function __construct()
    {
        $this->potions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $potion->setRecipe($this);
        }

        return $this;
    }

    public function removePotion(Potion $potion): self
    {
        if ($this->potions->removeElement($potion)) {
            // set the owning side to null (unless already changed)
            if ($potion->getRecipe() === $this) {
                $potion->setRecipe(null);
            }
        }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAverageValue(): ?string
    {
        return $this->averageValue;
    }

    public function setAverageValue(?string $averageValue): self
    {
        $this->averageValue = $averageValue;

        return $this;
    }
}
