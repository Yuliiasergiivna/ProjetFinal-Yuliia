<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Attraction>
     */
    #[ORM\OneToMany(targetEntity: Attraction::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $attraction;

    public function __construct()
    {
        $this->attraction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Attraction>
     */
    public function getAttraction(): Collection
    {
        return $this->attraction;
    }

    public function addAttraction(Attraction $attraction): static
    {
        if (!$this->attraction->contains($attraction)) {
            $this->attraction->add($attraction);
            $attraction->setCategory($this);
        }

        return $this;
    }

    public function removeAttraction(Attraction $attraction): static
    {
        if ($this->attraction->removeElement($attraction)) {
            // set the owning side to null (unless already changed)
            if ($attraction->getCategory() === $this) {
                $attraction->setCategory(null);
            }
        }

        return $this;
    }
}
