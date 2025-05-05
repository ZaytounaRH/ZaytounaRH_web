<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> origin/ons_gestion_recrutement
=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> origin/asma_gestion_presence
=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

>>>>>>> origin/manel_gestion_financiere
use App\Repository\EntretienRepository;

#[ORM\Entity(repositoryClass: EntretienRepository::class)]
#[ORM\Table(name: 'entretien')]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(name :"idEntretien",type: 'integer')]
=======
    #[ORM\Column(name: "idEntretien", type: 'integer')]
>>>>>>> origin/ons_gestion_recrutement
=======
    #[ORM\Column(name: "idEntretien", type: 'integer')]
>>>>>>> origin/asma_gestion_presence
=======
    #[ORM\Column(name :"idEntretien",type: 'integer')]
>>>>>>> origin/manel_gestion_financiere
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
<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(name:"dateEntretien" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateEntretien = null;

=======
=======
>>>>>>> origin/asma_gestion_presence
    #[ORM\Column(name:"dateEntretien", type: 'date', nullable: true)]
    #[Assert\NotNull(message: "La date de l'entretien est requise.")]
    #[Assert\GreaterThanOrEqual(
        value: "today",
        message: "La date de l'entretien doit être aujourd'hui ou dans le futur."
    )]
    private ?\DateTimeInterface $dateEntretien = null;




<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
    #[ORM\Column(name:"dateEntretien" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateEntretien = null;

>>>>>>> origin/manel_gestion_financiere
    public function getDateEntretien(): ?\DateTimeInterface
    {
        return $this->dateEntretien;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function setDateEntretien(\DateTimeInterface $dateEntretien): self
=======
    public function setDateEntretien(?\DateTimeInterface $dateEntretien): self
>>>>>>> origin/ons_gestion_recrutement
=======
    public function setDateEntretien(?\DateTimeInterface $dateEntretien): self
>>>>>>> origin/asma_gestion_presence
=======
    public function setDateEntretien(\DateTimeInterface $dateEntretien): self
>>>>>>> origin/manel_gestion_financiere
    {
        $this->dateEntretien = $dateEntretien;
        return $this;
    }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> origin/manel_gestion_financiere
    #[ORM\Column(name: "heureEntretien", type: 'datetime', nullable: false)]
    private ?\DateTime $heureEntretien = null;
    
    public function getHeureEntretien(): ?\DateTime
<<<<<<< HEAD
=======
=======
>>>>>>> origin/asma_gestion_presence

    #[ORM\Column(name: "heureEntretien", type: 'time', nullable: true)]
    #[Assert\NotNull(message: "L'heure de l'entretien est requise.")]
    private ?\DateTimeInterface $heureEntretien = null;
    
    public function getHeureEntretien(): ?\DateTimeInterface
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
    {
        return $this->heureEntretien;
    }
    
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function setHeureEntretien(\DateTime $heureEntretien): self
=======
    public function setHeureEntretien(?\DateTimeInterface $heureEntretien): self
>>>>>>> origin/ons_gestion_recrutement
=======
    public function setHeureEntretien(?\DateTimeInterface $heureEntretien): self
>>>>>>> origin/asma_gestion_presence
=======
    public function setHeureEntretien(\DateTime $heureEntretien): self
>>>>>>> origin/manel_gestion_financiere
    {
        $this->heureEntretien = $heureEntretien;
        return $this;
    }
    
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD

    #[ORM\Column(name:"typeEntretien" ,type: 'string', nullable: false)]
=======
    #[ORM\Column(name:"typeEntretien", type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le type d'entretien est requis.")]
>>>>>>> origin/ons_gestion_recrutement
=======
    #[ORM\Column(name:"typeEntretien", type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le type d'entretien est requis.")]
>>>>>>> origin/asma_gestion_presence
=======

    #[ORM\Column(name:"typeEntretien" ,type: 'string', nullable: false)]
>>>>>>> origin/manel_gestion_financiere
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
<<<<<<< HEAD
<<<<<<< HEAD
    private ?string $statut = null;
=======
    #[Assert\Choice(
        choices: ['EN_COURS', 'TERMINE', 'ANNULE','PLANIFIE'],
        message: "Le statut doit être 'EN_COURS', 'TERMINE' ou 'ANNULE' ou 'PLANIFIE."
    )]
    private ?string $statut = 'EN_COURS';
>>>>>>> origin/ons_gestion_recrutement
=======
    #[Assert\Choice(
        choices: ['EN_COURS', 'TERMINE', 'ANNULE'],
        message: "Le statut doit être 'EN_COURS', 'TERMINE' ou 'ANNULE'."
    )]
    private ?string $statut = 'EN_COURS';
>>>>>>> origin/asma_gestion_presence
=======
    private ?string $statut = null;
>>>>>>> origin/manel_gestion_financiere

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> origin/asma_gestion_presence
    #[Assert\Length(
        max: 500,
        maxMessage: "Le commentaire ne peut pas dépasser 500 caractères."
    )]
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
    #[Assert\NotNull(message: "Le candidat est requis pour cet entretien.")]
>>>>>>> origin/ons_gestion_recrutement
=======
    #[Assert\NotNull(message: "Le candidat est requis pour cet entretien.")]
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
    #[Assert\NotNull(message: "L'offre d'emploi est requise.")]
>>>>>>> origin/ons_gestion_recrutement
=======
    #[Assert\NotNull(message: "L'offre d'emploi est requise.")]
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
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
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======

>>>>>>> origin/manel_gestion_financiere
}
