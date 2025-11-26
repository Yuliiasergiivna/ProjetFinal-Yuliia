<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateNaissance = null;
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $photo = null;

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'utilisateur')]
    private Collection $comments;

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'utilisateur')]
    private Collection $photos;

    /**
     * @var Collection<int, Favorite>
     */
    #[ORM\OneToMany(targetEntity: Favorite::class, mappedBy: 'utilisateur')]
    private Collection $favorites;

    /**
     * @var Collection<int, Route>
     */
    #[ORM\OneToMany(targetEntity: Route::class, mappedBy: 'utilisateur')]
    private Collection $routes;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\ManyToMany(targetEntity: Comment::class, mappedBy: 'utilisateurs')]
    private Collection $likes;

    /**
     * @var Collection<int, Attraction>
     */
    #[ORM\ManyToMany(targetEntity: Attraction::class, inversedBy: 'utilisateurs', cascade: ['persist'])]
    private Collection $attractionLikes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->routes = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->attractionLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    // public function __serialize(): array
    // {
    //     // $data = (array) $this;
    //     // $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

    //     // return $data;
    //         return [
    //     'id' => $this->id,
    //     'email' => $this->email,
    //     'roles' => $this->roles,
    // ];
    // }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUtilisateur($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUtilisateur() === $this) {
                $comment->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setUtilisateur($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getUtilisateur() === $this) {
                $photo->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setUtilisateur($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUtilisateur() === $this) {
                $favorite->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Route>
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(Route $route): static
    {
        if (!$this->routes->contains($route)) {
            $this->routes->add($route);
            $route->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRoute(Route $route): static
    {
        if ($this->routes->removeElement($route)) {
            // set the owning side to null (unless already changed)
            if ($route->getUtilisateur() === $this) {
                $route->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Comment $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
        }

        return $this;
    }

    public function removeLike(Comment $like): static
    {
        $this->likes->removeElement($like);

        return $this;
    }

    /**
     * @return Collection<int, Attraction>
     */
    public function getAttractionLikes(): Collection
    {
        return $this->attractionLikes;
    }

    public function addAttractionLike(Attraction $attractionLike): static
    {
        if (!$this->attractionLikes->contains($attractionLike)) {
            $this->attractionLikes->add($attractionLike);
        }

        return $this;
    }

    public function removeAttractionLike(Attraction $attractionLike): static
    {
        $this->attractionLikes->removeElement($attractionLike);

        return $this;
    }
    
}
