<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\PresenceRepository;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
#[ORM\Table(name: 'presence')]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id_presence = null;

    public function getId_presence(): ?int
    {
        return $this->id_presence;
    }

    public function setId_presence(int $id_presence): self
    {
        $this->id_presence = $id_presence;
        return $this;
    }

    #[ORM\Column(type: 'date', nullable: false)]
    private ?\DateTimeInterface $date = null;

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(name:"heureArrive",type: 'time', nullable: false)]
    private ?string $heureArrive = null;

    public function getHeureArrive(): ?string
=======
=======
>>>>>>> origin/asma_gestion_presence
    #[ORM\Column(name: "heureArrive", type: 'time', nullable: false)]
    private ?\DateTimeInterface $heureArrive = null;

    public function getHeureArrive(): ?\DateTimeInterface
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
    {
        return $this->heureArrive;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function setHeureArrive(string $heureArrive): self
=======
    public function setHeureArrive(\DateTimeInterface $heureArrive): self
>>>>>>> origin/ons_gestion_recrutement
=======
    public function setHeureArrive(\DateTimeInterface $heureArrive): self
>>>>>>> origin/asma_gestion_presence
    {
        $this->heureArrive = $heureArrive;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\Column(name:"heureDepart",type: 'time', nullable: false)]
    private ?string $heureDepart = null;

    public function getHeureDepart(): ?string
=======
=======
>>>>>>> origin/asma_gestion_presence
    #[ORM\Column(name: "heureDepart", type: 'time', nullable: false)]
    private ?\DateTimeInterface $heureDepart = null;

    public function getHeureDepart(): ?\DateTimeInterface
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence
    {
        return $this->heureDepart;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function setHeureDepart(string $heureDepart): self
=======
    public function setHeureDepart(\DateTimeInterface $heureDepart): self
>>>>>>> origin/ons_gestion_recrutement
=======
    public function setHeureDepart(\DateTimeInterface $heureDepart): self
>>>>>>> origin/asma_gestion_presence
    {
        $this->heureDepart = $heureDepart;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'presences')]
    #[ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')]
    private ?Employee $employee = null;

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Rh::class, inversedBy: 'presences')]
    #[ORM\JoinColumn(name: 'rh_id', referencedColumnName: 'rh_id')]
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

    public function getIdPresence(): ?int
    {
        return $this->id_presence;
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> origin/asma_gestion_presence
    public function __construct()
{
    $this->date = new \DateTime(); // date du jour
    $this->heureArrive = new \DateTime(); // heure d’arrivée automatique
    $this->heureDepart = new \DateTime(); // tu peux laisser vide si départ = + tard
}
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence

}
