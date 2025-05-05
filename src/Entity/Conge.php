<?php

namespace App\Entity;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> origin/asma_gestion_presence
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Callback;

<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\CongeRepository;

#[ORM\Entity(repositoryClass: CongeRepository::class)]
#[ORM\Table(name: 'conge')]
class Conge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id_conge = null;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> origin/asma_gestion_presence
    #[ORM\Column(name: "dateDebut", type: 'date', nullable: false)]
#[Assert\NotBlank(message: "La date de début est requise.")]
private ?\DateTimeInterface $dateDebut = null;

#[ORM\Column(name: "dateFin", type: 'date', nullable: false)]
#[Assert\NotBlank(message: "La date de fin est requise.")]
private ?\DateTimeInterface $dateFin = null;


    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le motif est requis.")]
    #[Assert\Length(min: 3, minMessage: "Le motif doit contenir au moins 3 caractères.")]
    private ?string $motif = null;

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $statut = null;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'conges')]
    #[ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')]
    private ?Employee $employee = null;

    #[ORM\ManyToOne(targetEntity: Rh::class, inversedBy: 'conges')]
    #[ORM\JoinColumn(name: 'rh_id', referencedColumnName: 'rh_id', nullable: false)]
    private ?Rh $rh = null;

    public function __construct()
    {
        $this->statut = 'ENATTENTE'; // valeur par défaut
    }

    #[Callback]
    public function validateDates(ExecutionContextInterface $context): void
    {
        if ($this->dateDebut && $this->dateFin && $this->dateFin < $this->dateDebut) {
            $context->buildViolation('La date de fin doit être après la date de début.')
                ->atPath('dateFin')
                ->addViolation();
        }
    }

    // Getters / Setters

<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
    public function getId_conge(): ?int
    {
        return $this->id_conge;
    }

    public function setId_conge(int $id_conge): self
    {
        $this->id_conge = $id_conge;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(name:"dateDebut" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateDebut = null;

=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
    #[ORM\Column(name:"dateDebut" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateDebut = null;

>>>>>>> origin/manel_gestion_financiere
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(name :"dateFin" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateFin = null;

=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
    #[ORM\Column(name :"dateFin" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateFin = null;

>>>>>>> origin/manel_gestion_financiere
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $motif = null;

=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $motif = null;

>>>>>>> origin/manel_gestion_financiere
    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $statut = null;

=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
    #[ORM\Column(type: 'string', nullable: false)]
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

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> origin/manel_gestion_financiere
    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'conges')]
    #[ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')]
    private ?Employee $employee = null;

<<<<<<< HEAD
=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> origin/manel_gestion_financiere
    #[ORM\ManyToOne(targetEntity: Rh::class, inversedBy: 'conges')]
    #[ORM\JoinColumn(name: 'rh_id', referencedColumnName: 'rh_id')]
    private ?Rh $rh = null;

<<<<<<< HEAD
=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
=======
>>>>>>> origin/manel_gestion_financiere
    public function getRh(): ?Rh
    {
        return $this->rh;
    }

    public function setRh(?Rh $rh): self
    {
        $this->rh = $rh;
        return $this;
    }

    public function getIdConge(): ?int
    {
        return $this->id_conge;
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