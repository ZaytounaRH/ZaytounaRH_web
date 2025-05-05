<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Enum\StatutOffreemploi;
use App\Repository\OffreemploiRepository;
<<<<<<< HEAD
=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> origin/ons_gestion_recrutement

#[ORM\Entity(repositoryClass: OffreemploiRepository::class)]
#[ORM\Table(name: 'offreemploi')]
class Offreemploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"idOffre" , type: 'integer')]
    private ?int $idOffre = null;
    public function getId(): ?int
    {
        return $this->idOffre;
    }
    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function setIdOffre(int $idOffre): self
    {
        $this->idOffre = $idOffre;
        return $this;
    }
<<<<<<< HEAD

    #[ORM\Column(name:"titreOffre",type: 'string', nullable: false)]
    private ?string $titreOffre = null;
=======
    #[ORM\Column(name:"titreOffre", type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le titre de l'offre est requis.")]
    #[Assert\Length(
        min: 5,
        max: 100,
        minMessage: "Le titre doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $titreOffre = null;
    
>>>>>>> origin/ons_gestion_recrutement

    public function getTitreOffre(): ?string
    {
        return $this->titreOffre;
    }

    public function setTitreOffre(string $titreOffre): self
    {
        $this->titreOffre = $titreOffre;
        return $this;
    }
<<<<<<< HEAD

    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $description = null;

=======
    #[ORM\Column(type: 'text', nullable: false)]
    #[Assert\NotBlank(message: "La description est requise.")]
    #[Assert\Length(
        min: 10,
        minMessage: "La description doit contenir au moins {{ limit }} caractères."
    )]
    private ?string $description = null;

    



>>>>>>> origin/ons_gestion_recrutement
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

<<<<<<< HEAD
    #[ORM\Column(name:"datePublication",type: 'date', nullable: false)]
    private ?\DateTimeInterface $datePublication = null;
=======


   
    #[ORM\Column(name:"datePublication", type: 'date', nullable: false)]
    #[Assert\NotNull(message: "La date de l'offre est requise.")]
    #[Assert\GreaterThanOrEqual(
        value: "today",
        message: "La date de l'offre doit être aujourd'hui ou dans le futur."
    )]
    private ?\DateTimeInterface $datePublication = null;
    
>>>>>>> origin/ons_gestion_recrutement

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;
        return $this;
    }

<<<<<<< HEAD
    #[ORM\Column(type: 'float', nullable: false)]
    private ?float $salaire = null;
=======
#[ORM\Column(type: 'float', nullable: false)]
#[Assert\NotNull(message: "Le salaire est requis.")]
#[Assert\Positive(message: "Le salaire doit être un nombre positif.")]
private ?float $salaire = null;



>>>>>>> origin/ons_gestion_recrutement

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
<<<<<<< HEAD
    private ?string $statut = null;
=======
    #[Assert\NotBlank(message: "Le statut de l'offre est requis.")]
    #[Assert\Choice(
        choices: ['OUVERTE', 'FERMEE', 'POURVUE', 'ANNULEE', 'ENCOURS'],
        message: "Le statut doit être l'une des valeurs suivantes : {{ choices }}."
    )]
    private ?string $statut = null;
    
    
>>>>>>> origin/ons_gestion_recrutement

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

<<<<<<< HEAD
=======

    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image = null;
    
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
    
 

>>>>>>> origin/ons_gestion_recrutement
    #[ORM\ManyToOne(targetEntity: Rh::class, inversedBy: 'offreemplois')]
    #[ORM\JoinColumn(name: 'idRH', referencedColumnName: 'rh_id')]
    private ?Rh $rh = null;

    public function getRh(): ?Rh
    {
        return $this->rh;
    }

    public function setRh(?Rh $rh): self
    {
        $this->rh = $rh;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Entretien::class, mappedBy: 'offreemploi')]
    private Collection $entretiens;

    public function __construct()
    {
        $this->entretiens = new ArrayCollection();
    }

    /**
     * @return Collection<int, Entretien>
     */
    public function getEntretiens(): Collection
    {
        if (!$this->entretiens instanceof Collection) {
            $this->entretiens = new ArrayCollection();
        }
        return $this->entretiens;
    }

    public function addEntretien(Entretien $entretien): self
    {
        if (!$this->getEntretiens()->contains($entretien)) {
            $this->getEntretiens()->add($entretien);
        }
        return $this;
    }

    public function removeEntretien(Entretien $entretien): self
    {
        $this->getEntretiens()->removeElement($entretien);
        return $this;
    }

}
