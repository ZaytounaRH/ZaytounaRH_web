<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\DepenseRepository;

#[ORM\Entity(repositoryClass: DepenseRepository::class)]
#[ORM\Table(name: 'depense')]
class Depense
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

    #[ORM\Column(name:"montantDepense" , type: 'decimal', nullable: false)]
    private ?float $montantDepense = null;

    public function getMontantDepense(): ?float
    {
        return $this->montantDepense;
    }

    public function setMontantDepense(float $montantDepense): self
    {
        $this->montantDepense = $montantDepense;
        return $this;
    }

    #[ORM\Column(name:"dateDepense", type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateDepense = null;

    public function getDateDepense(): ?\DateTimeInterface
    {
        return $this->dateDepense;
    }

    public function setDateDepense(\DateTimeInterface $dateDepense): self
    {
        $this->dateDepense = $dateDepense;
        return $this;
    }

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Budget::class, inversedBy: 'depenses')]
    #[ORM\JoinColumn(name: 'idBudget', referencedColumnName: 'id')]
    private ?Budget $budget = null;

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;
        return $this;
    }

}