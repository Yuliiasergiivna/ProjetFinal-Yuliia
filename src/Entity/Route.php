<?php

namespace App\Entity;

use App\Repository\RouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteRepository::class)]
class Route
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, RouteAttraction>
     */
    #[ORM\OneToMany(targetEntity: RouteAttraction::class, mappedBy: 'route', orphanRemoval: true)]
    private Collection $routeAttraction;

    public function __construct()
    {
        $this->routeAttraction = new ArrayCollection();
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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, RouteAttraction>
     */
    public function getRouteAttraction(): Collection
    {
        return $this->routeAttraction;
    }

    public function addRouteAttraction(RouteAttraction $routeAttraction): static
    {
        if (!$this->routeAttraction->contains($routeAttraction)) {
            $this->routeAttraction->add($routeAttraction);
            $routeAttraction->setRoute($this);
        }

        return $this;
    }

    public function removeRouteAttraction(RouteAttraction $routeAttraction): static
    {
        if ($this->routeAttraction->removeElement($routeAttraction)) {
            // set the owning side to null (unless already changed)
            if ($routeAttraction->getRoute() === $this) {
                $routeAttraction->setRoute(null);
            }
        }

        return $this;
    }
}
