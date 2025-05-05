<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\ReponseRepository;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
#[ORM\Table(name: 'reponse')]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idRep', type: 'integer')]
    private ?int $idRep = null;

    public function getIdRep(): ?int
    {
        return $this->idRep;
    }

    public function setIdRep(int $idRep): self
    {
        $this->idRep = $idRep;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $contenu = null;

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;
        return $this;
    }

    #[ORM\Column(name: "dateRep" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateRep = null;

    public function getDateRep(): ?\DateTimeInterface
    {
        return $this->dateRep;
    }

    public function setDateRep(\DateTimeInterface $dateRep): self
    {
        $this->dateRep = $dateRep;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Reclamation::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(name: 'reclamationId', referencedColumnName: 'idR')]
    private ?Reclamation $reclamation = null;

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;
        return $this;
    }

}