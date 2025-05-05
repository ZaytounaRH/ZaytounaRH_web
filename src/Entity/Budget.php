<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\BudgetRepository;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
#[ORM\Table(name: 'budget')]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: "montantAlloue", type: 'float', nullable: false)]
    private ?float $montantAlloue = null;

    #[ORM\Column(name: "dateDebut", type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(name: "dateFin", type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(name: "typeBudget", type: 'string', nullable: false)]
    private ?string $typeBudget = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'budgets')]
    #[ORM\JoinColumn(name: 'idResponsable', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Depense::class)]
    private Collection $depenses;

    public function __construct()
    {
        $this->depenses = new ArrayCollection();
    }

    // Getters & setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMontantAlloue(): ?float
    {
        return $this->montantAlloue;
    }

    public function setMontantAlloue(float $montantAlloue): self
    {
        $this->montantAlloue = $montantAlloue;
        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getTypeBudget(): ?string
    {
        return $this->typeBudget;
    }

    public function setTypeBudget(string $typeBudget): self
    {
        $this->typeBudget = $typeBudget;
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

    /**
     * @return Collection<int, Depense>
     */
    public function getDepenses(): Collection
    {
        return $this->depenses;
    }

    public function addDepense(Depense $depense): self
    {
        if (!$this->depenses->contains($depense)) {
            $this->depenses[] = $depense;
        }
        return $this;
    }

    public function removeDepense(Depense $depense): self
    {
        $this->depenses->removeElement($depense);
        return $this;
    }
}