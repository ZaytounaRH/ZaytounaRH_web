<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\EmployeeRepository;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\Table(name: 'employee')]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"employee_id",type: 'integer')]
    private ?int $employee_id = null;
    public function getId(): ?int
    {
        return $this->employee_id;
    }
    public function getEmployee_id(): ?int
    {
        return $this->employee_id;
    }

    public function setEmployee_id(int $employee_id): self
    {
        $this->employee_id = $employee_id;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'employees')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Conge::class, mappedBy: 'employee')]
    private Collection $conges;

    /**
     * @return Collection<int, Conge>
     */
    public function getConges(): Collection
    {
        if (!$this->conges instanceof Collection) {
            $this->conges = new ArrayCollection();
        }
        return $this->conges;
    }

    public function addConge(Conge $conge): self
    {
        if (!$this->getConges()->contains($conge)) {
            $this->getConges()->add($conge);
        }
        return $this;
    }

    public function removeConge(Conge $conge): self
    {
        $this->getConges()->removeElement($conge);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'employee')]
    private Collection $presences;

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        if (!$this->presences instanceof Collection) {
            $this->presences = new ArrayCollection();
        }
        return $this->presences;
    }

    public function addPresence(Presence $presence): self
    {
        if (!$this->getPresences()->contains($presence)) {
            $this->getPresences()->add($presence);
        }
        return $this;
    }

    public function removePresence(Presence $presence): self
    {
        $this->getPresences()->removeElement($presence);
        return $this;
    }

    #[ORM\ManyToMany(targetEntity: Certification::class, inversedBy: 'employees')]
    #[ORM\JoinTable(
        name: 'employe_certification',
        joinColumns: [
            new ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'idCertif', referencedColumnName: 'idCertif')
        ]
    )]
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

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'employees')]
    #[ORM\JoinTable(
        name: 'employe_formation',
        joinColumns: [
            new ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'employee_id')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'idFormation', referencedColumnName: 'idFormation')
        ]
    )]
    private Collection $formations;

    public function __construct()
    {
        $this->conges = new ArrayCollection();
        $this->presences = new ArrayCollection();
        $this->certifications = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        if (!$this->formations instanceof Collection) {
            $this->formations = new ArrayCollection();
        }
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->getFormations()->contains($formation)) {
            $this->getFormations()->add($formation);
        }
        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        $this->getFormations()->removeElement($formation);
        return $this;
    }

    public function getEmployeeId(): ?int
    {
        return $this->employee_id;
    }

}
