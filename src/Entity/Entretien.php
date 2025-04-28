<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EntretienRepository;

#[ORM\Entity(repositoryClass: EntretienRepository::class)]
#[ORM\Table(name: 'entretien')]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idEntretien", type: 'integer')]
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

    #[ORM\Column(name:"dateEntretien", type: 'date', nullable: true)]
    #[Assert\NotNull(message: "La date de l'entretien est requise.")]
    #[Assert\GreaterThanOrEqual(
        value: "today",
        message: "La date de l'entretien doit être aujourd'hui ou dans le futur."
    )]
    private ?\DateTimeInterface $dateEntretien = null;




    public function getDateEntretien(): ?\DateTimeInterface
    {
        return $this->dateEntretien;
    }

    public function setDateEntretien(?\DateTimeInterface $dateEntretien): self
    {
        $this->dateEntretien = $dateEntretien;
        return $this;
    }

    #[ORM\Column(name: "heureEntretien", type: 'time', nullable: true)]
    #[Assert\NotNull(message: "L'heure de l'entretien est requise.")]
    private ?\DateTimeInterface $heureEntretien = null;
    
    public function getHeureEntretien(): ?\DateTimeInterface
    {
        return $this->heureEntretien;
    }
    
    public function setHeureEntretien(?\DateTimeInterface $heureEntretien): self
    {
        $this->heureEntretien = $heureEntretien;
        return $this;
    }
    
    #[ORM\Column(name:"typeEntretien", type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le type d'entretien est requis.")]
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
    #[Assert\Choice(
        choices: ['EN_COURS', 'TERMINE', 'ANNULE','PLANIFIE'],
        message: "Le statut doit être 'EN_COURS', 'TERMINE' ou 'ANNULE' ou 'PLANIFIE."
    )]
    private ?string $statut = 'EN_COURS';

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
    #[Assert\Length(
        max: 500,
        maxMessage: "Le commentaire ne peut pas dépasser 500 caractères."
    )]
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
    #[Assert\NotNull(message: "Le candidat est requis pour cet entretien.")]
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
    #[Assert\NotNull(message: "L'offre d'emploi est requise.")]
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
}
