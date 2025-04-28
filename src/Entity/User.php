<?php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface; // Import UserInterface
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface; // Import PasswordAuthenticatedUserInterface

use App\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface // Implement both UserInterface and PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Column(name: "numTel", type: "string", length: 255, nullable: true)]
    private ?string $numTel = null;

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;
        return $this;
    }

    #[ORM\Column(name: "JoursOuvrables", type: 'integer', nullable: false)]
    private ?int $joursOuvrables = null;

    public function getJoursOuvrables(): ?int
    {
        return $this->joursOuvrables;
    }

    public function setJoursOuvrables(int $joursOuvrables): self
    {
        $this->joursOuvrables = $joursOuvrables;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $nom = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $prenom = null;

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $address = null;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $gender = null;

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    #[ORM\Column(name: "dateDeNaissance", type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): self
    {
        $this->dateDeNaissance = $dateDeNaissance;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $user_type = null;

    public function getUserType(): ?string
{
    return $this->user_type;
}

    public function setUserType(string $user_type): self
    {
        $this->user_type = $user_type;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $password = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    // Add missing getUserIdentifier method
    public function getUserIdentifier(): string
    {
        return $this->email; // Assuming email is the unique identifier
    }

    // Implement eraseCredentials() method to erase sensitive data
    public function eraseCredentials(): void
    {
        $this->password = null; // Clear the password after authentication
    }

    #[ORM\OneToMany(targetEntity: Assurance::class, mappedBy: 'user')]
    private Collection $assurances;

    public function getAssurances(): Collection
    {
        if (!$this->assurances instanceof Collection) {
            $this->assurances = new ArrayCollection();
        }
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): self
    {
        if (!$this->getAssurances()->contains($assurance)) {
            $this->getAssurances()->add($assurance);
        }
        return $this;
    }

    public function removeAssurance(Assurance $assurance): self
    {
        $this->getAssurances()->removeElement($assurance);
        return $this;
    }

    public function getRoles(): array
{
    $roles = ['ROLE_USER']; // Default role

    // Add role based on user_type
    if ($this->user_type === 'RH') {
        $roles[] = 'ROLE_RH';
    } elseif ($this->user_type === 'EMPLOYEE') {
        $roles[] = 'ROLE_EMPLOYEE';
    } elseif ($this->user_type === 'CANDIDAT') {
        $roles[] = 'ROLE_CANDIDAT';
    }

    return array_unique($roles);
}

}
