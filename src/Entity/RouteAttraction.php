<?php

namespace App\Entity;

use App\Repository\RouteAttractionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteAttractionRepository::class)]
class RouteAttraction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'routeAttractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Attraction $attraction = null;

    #[ORM\ManyToOne(inversedBy: 'routeAttraction')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Route $route = null;

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

    public function getAttraction(): ?Attraction
    {
        return $this->attraction;
    }

    public function setAttraction(?Attraction $attraction): static
    {
        $this->attraction = $attraction;

        return $this;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRoute(?Route $route): static
    {
        $this->route = $route;

        return $this;
    }
}
