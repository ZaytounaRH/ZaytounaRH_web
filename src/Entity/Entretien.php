<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> origin/ons_gestion_recrutement
use App\Repository\EntretienRepository;

#[ORM\Entity(repositoryClass: EntretienRepository::class)]
#[ORM\Table(name: 'entretien')]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
<<<<<<< HEAD
    #[ORM\Column(name :"idEntretien",type: 'integer')]
=======
    #[ORM\Column(name: "idEntretien", type: 'integer')]
>>>>>>> origin/ons_gestion_recrutement
    private ?int $idEntretien = null;

    public function getIdEntretien(): ?int
    {
        return $this->idEntretien;
    }

    public function setIdEntretien(int $idEntretien): self
    {
        $this->idEntretien = $idEntretien;
        return $this;
    }

<<<<<<< HEAD
    #[ORM\Column(name:"dateEntretien" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateEntretien = null;

=======
    #[ORM\Column(name:"dateEntretien", type: 'date', nullable: true)]
    #[Assert\NotNull(message: "La date de l'entretien est requise.")]
    #[Assert\GreaterThanOrEqual(
        value: "today",
        message: "La date de l'entretien doit être aujourd'hui ou dans le futur."
    )]
    private ?\DateTimeInterface $dateEntretien = null;




>>>>>>> origin/ons_gestion_recrutement
    public function getDateEntretien(): ?\DateTimeInterface
    {
        return $this->dateEntretien;
    }

<<<<<<< HEAD
    public function setDateEntretien(\DateTimeInterface $dateEntretien): self
=======
    public function setDateEntretien(?\DateTimeInterface $dateEntretien): self
>>>>>>> origin/ons_gestion_recrutement
    {
        $this->dateEntretien = $dateEntretien;
        return $this;
    }
<<<<<<< HEAD
    #[ORM\Column(name: "heureEntretien", type: 'datetime', nullable: false)]
    private ?\DateTime $heureEntretien = null;
    
    public function getHeureEntretien(): ?\DateTime
=======

    #[ORM\Column(name: "heureEntretien", type: 'time', nullable: true)]
    #[Assert\NotNull(message: "L'heure de l'entretien est requise.")]
    private ?\DateTimeInterface $heureEntretien = null;
    
    public function getHeureEntretien(): ?\DateTimeInterface
>>>>>>> origin/ons_gestion_recrutement
    {
        return $this->heureEntretien;
    }
    
<<<<<<< HEAD
    public function setHeureEntretien(\DateTime $heureEntretien): self
=======
    public function setHeureEntretien(?\DateTimeInterface $heureEntretien): self
>>>>>>> origin/ons_gestion_recrutement
    {
        $this->heureEntretien = $heureEntretien;
        return $this;
    }
    
<<<<<<< HEAD

    #[ORM\Column(name:"typeEntretien" ,type: 'string', nullable: false)]
=======
    #[ORM\Column(name:"typeEntretien", type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le type d'entretien est requis.")]
>>>>>>> origin/ons_gestion_recrutement
    private ?string $typeEntretien = null;

    public function getTypeEntretien(): ?string
    {
        return $this->typeEntretien;
    }

    public function setTypeEntretien(string $typeEntretien): self
    {
        $this->typeEntretien = $typeEntretien;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
<<<<<<< HEAD
    private ?string $statut = null;
=======
    #[Assert\Choice(
        choices: ['EN_COURS', 'TERMINE', 'ANNULE','PLANIFIE'],
        message: "Le statut doit être 'EN_COURS', 'TERMINE' ou 'ANNULE' ou 'PLANIFIE."
    )]
    private ?string $statut = 'EN_COURS';
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

    #[ORM\Column(type: 'text', nullable: true)]
<<<<<<< HEAD
=======
    #[Assert\Length(
        max: 500,
        maxMessage: "Le commentaire ne peut pas dépasser 500 caractères."
    )]
>>>>>>> origin/ons_gestion_recrutement
    private ?string $commentaire = null;

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Candidat::class, inversedBy: 'entretiens')]
    #[ORM\JoinColumn(name: 'candidat_id', referencedColumnName: 'candidat_id')]
<<<<<<< HEAD
=======
    #[Assert\NotNull(message: "Le candidat est requis pour cet entretien.")]
>>>>>>> origin/ons_gestion_recrutement
    private ?Candidat $candidat = null;

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Offreemploi::class, inversedBy: 'entretiens')]
    #[ORM\JoinColumn(name: 'idOffre', referencedColumnName: 'idOffre')]
<<<<<<< HEAD
=======
    #[Assert\NotNull(message: "L'offre d'emploi est requise.")]
>>>>>>> origin/ons_gestion_recrutement
    private ?Offreemploi $offreemploi = null;

    public function getOffreemploi(): ?Offreemploi
    {
        return $this->offreemploi;
    }

    public function setOffreemploi(?Offreemploi $offreemploi): self
    {
        $this->offreemploi = $offreemploi;
        return $this;
    }
<<<<<<< HEAD

=======
>>>>>>> origin/ons_gestion_recrutement
}
