<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\CertificationRepository;

#[ORM\Entity(repositoryClass: CertificationRepository::class)]
#[ORM\Table(name: 'certification')]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name :"idCertif",type: 'integer')]
    private ?int $idCertif = null;

    public function getIdCertif(): ?int
    {
        return $this->idCertif;
    }

    public function setIdCertif(int $idCertif): self
    {
        $this->idCertif = $idCertif;
        return $this;
    }

    #[ORM\Column(name:"titreCertif",type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]

    private ?string $titreCertif = null;

    public function getTitreCertif(): ?string
    {
        return $this->titreCertif;
    }

    public function setTitreCertif(string $titreCertif): self
    {
        $this->titreCertif = $titreCertif;
        return $this;
    }

    #[ORM\Column(name:"organismeCertif",type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]

    private ?string $organismeCertif = null;

    public function getOrganismeCertif(): ?string
    {
        return $this->organismeCertif;
    }

    public function setOrganismeCertif(string $organismeCertif): self
    {
        $this->organismeCertif = $organismeCertif;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Formation::class, inversedBy: 'certifications')]
    #[ORM\JoinColumn(name: 'idFormation', referencedColumnName: 'idFormation')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]

    private ?Formation $formation = null;

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;
        return $this;
    }

    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: 'certifications')]
    #[ORM\JoinTable(
        name: 'employe_certification',
        joinColumns: [
            new ORM\JoinColumn(name: 'idCertif', referencedColumnName: 'idCertif')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')
        ]
    )]
    private Collection $employees;

    public function __construct()
    {
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

}
