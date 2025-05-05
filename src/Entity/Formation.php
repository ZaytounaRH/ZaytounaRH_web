<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\FormationRepository;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ORM\Table(name: 'formation')]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name :"idFormation",type: 'integer')]
    private ?int $idFormation = null;

    public function getIdFormation(): ?int
    {
        return $this->idFormation;
    }

    public function setIdFormation(int $idFormation): self
    {
        $this->idFormation = $idFormation;
        return $this;
    }

    #[ORM\Column(name :"nomFormation",type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]

    private ?string $nomFormation = null;

    public function getNomFormation(): ?string
    {
        return $this->nomFormation;
    }

    public function setNomFormation(string $nomFormation): self
    {
        $this->nomFormation = $nomFormation;
        return $this;
    }

    #[ORM\Column(name :"descriptionFormation",type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]

    private ?string $descriptionFormation = null;

    public function getDescriptionFormation(): ?string
    {
        return $this->descriptionFormation;
    }

    public function setDescriptionFormation(string $descriptionFormation): self
    {
        $this->descriptionFormation = $descriptionFormation;
        return $this;
    }

    #[ORM\Column(name :"dateDebutFormation",type: 'date', nullable: false)]
    #[Assert\NotNull(message: 'Ce champ ne peut pas être vide.')]

#[Assert\GreaterThanOrEqual("today", message: "La date de début ne peut pas être dans le passé.")]
    private ?\DateTimeInterface $dateDebutFormation = null;

    public function getDateDebutFormation(): ?\DateTimeInterface
    {
        return $this->dateDebutFormation;
    }

    public function setDateDebutFormation(\DateTimeInterface $dateDebutFormation): self
    {
        $this->dateDebutFormation = $dateDebutFormation;
        return $this;
    }

    #[ORM\Column(name :"dateFinFormation",type: 'date', nullable: false)]
    #[Assert\NotNull(message: 'Ce champ ne peut pas être vide.')]
#[Assert\GreaterThanOrEqual("today", message: "La date de fin ne peut pas être dans le passé.")]
    private ?\DateTimeInterface $dateFinFormation = null;

    public function getDateFinFormation(): ?\DateTimeInterface
    {
        return $this->dateFinFormation;
    }

    public function setDateFinFormation(\DateTimeInterface $dateFinFormation): self
    {
        $this->dateFinFormation = $dateFinFormation;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Certification::class, mappedBy: 'formation')]
    private Collection $certifications;

    /**
     * @return Collection<int, Certification>
     */
    public function getCertifications(): Collection
    {
        if (!$this->certifications instanceof Collection) {
            $this->certifications = new ArrayCollection();
        }
        return $this->certifications;
    }

    public function addCertification(Certification $certification): self
    {
        if (!$this->getCertifications()->contains($certification)) {
            $this->getCertifications()->add($certification);
        }
        return $this;
    }

    public function removeCertification(Certification $certification): self
    {
        $this->getCertifications()->removeElement($certification);
        return $this;
    }

    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: 'formations')]
    #[ORM\JoinTable(
        name: 'employe_formation',
        joinColumns: [
            new ORM\JoinColumn(name: 'idFormation', referencedColumnName: 'idFormation')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')
        ]
    )]
    private Collection $employees;

    public function __construct()
    {
        $this->certifications = new ArrayCollection();
        $this->employees = new ArrayCollection();
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        if (!$this->employees instanceof Collection) {
            $this->employees = new ArrayCollection();
        }
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->getEmployees()->contains($employee)) {
            $this->getEmployees()->add($employee);
        }
        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        $this->getEmployees()->removeElement($employee);
        return $this;
    }

    #[Assert\Callback]
public function validateDates(ExecutionContextInterface $context, $payload)
{
    if ($this->dateDebutFormation && $this->dateFinFormation) {
        if ($this->dateFinFormation < $this->dateDebutFormation) {
            $context->buildViolation('La date de fin doit être postérieure à la date de début.')
                ->atPath('dateFinFormation')
                ->addViolation();
        }
    }
}

}
