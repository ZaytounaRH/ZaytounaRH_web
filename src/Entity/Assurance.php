<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Reclamation;
use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
#[ORM\Table(name: 'assurance')]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idA", type: "integer")]
    private ?int $idA = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Le nom de l’assurance est obligatoire.')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Le nom est trop court (minimum {{ limit }} caractères).',
        maxMessage: 'Le nom est trop long (maximum {{ limit }} caractères).'
    )]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Le type de l’assurance est obligatoire.')]
    #[Assert\Choice(
        choices: ['SANTE', 'ACCIDENT_TRAVAIL', 'VIE', 'RESPONSABILITE_CIVILE'],
        message: 'Le type "{{ value }}" est invalide. Veuillez choisir un type valide.'
    )]
    private ?string $type = null;

    #[ORM\Column(name: "dateExpiration", type: 'date', nullable: false)]
    #[Assert\NotNull(message: 'La date d’expiration est requise.')]
    #[Assert\GreaterThan(value: 'today +1 year', message: 'La date d’expiration doit être supérieure à un an à partir d’aujourd’hui.')]
    private ?\DateTimeInterface $dateExpiration = null;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'assurances')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'id')]
    #[Assert\NotNull(message: 'Un utilisateur doit être sélectionné.')]
    private ?User $user = null;


    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'assurance')]
    private Collection $reclamations;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }

    public function getIdA(): ?int
    {
        return $this->idA;
    }

    // Ajout du getter générique attendu par Doctrine/Symfony
    public function getId(): ?int
    {
        return $this->idA;
    }

    public function setIdA(int $idA): self
    {
        $this->idA = $idA;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
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

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setAssurance($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getAssurance() === $this) {
                $reclamation->setAssurance(null);
            }
        }

        return $this;
    }
}
