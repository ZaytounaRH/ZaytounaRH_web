<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User
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

   /* #[ORM\Column(type: 'string', nullable: false)]
    private ?string $numTel = null;
*/
#[ORM\Column(name: "numTel", type: "string", length: 255, nullable: true)]
private ?string $numTel = null;
    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;
        return $this;
    }

    #[ORM\Column(name: "JoursOuvrables" ,type: 'integer', nullable: false)]
    private ?int $joursOuvrables = null;

    public function getJoursOuvrables(): ?int
    {
        return $this->joursOuvrables;
    }

    public function setJoursOuvrables(int $joursOuvrables): self
    {
        $this->joursOuvrables = $joursOuvrables;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $nom = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $prenom = null;

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $address = null;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $gender = null;

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    #[ORM\Column(name: "dateDeNaissance" ,type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): self
    {
        $this->dateDeNaissance = $dateDeNaissance;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $user_type = null;

    public function getUser_type(): ?string
    {
        return $this->user_type;
    }

    public function setUser_type(string $user_type): self
    {
        $this->user_type = $user_type;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $password = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Assurance::class, mappedBy: 'user')]
    private Collection $assurances;

    /**
     * @return Collection<int, Assurance>
     */
    public function getAssurances(): Collection
    {
        if (!$this->assurances instanceof Collection) {
            $this->assurances = new ArrayCollection();
        }
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): self
    {
        if (!$this->getAssurances()->contains($assurance)) {
            $this->getAssurances()->add($assurance);
        }
        return $this;
    }

    public function removeAssurance(Assurance $assurance): self
    {
        $this->getAssurances()->removeElement($assurance);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Budget::class, mappedBy: 'user')]
    private Collection $budgets;

    /**
     * @return Collection<int, Budget>
     */
    public function getBudgets(): Collection
    {
        if (!$this->budgets instanceof Collection) {
            $this->budgets = new ArrayCollection();
        }
        return $this->budgets;
    }

    public function addBudget(Budget $budget): self
    {
        if (!$this->getBudgets()->contains($budget)) {
            $this->getBudgets()->add($budget);
        }
        return $this;
    }

    public function removeBudget(Budget $budget): self
    {
        $this->getBudgets()->removeElement($budget);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'user')]
    private Collection $candidats;

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidats(): Collection
    {
        if (!$this->candidats instanceof Collection) {
            $this->candidats = new ArrayCollection();
        }
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->getCandidats()->contains($candidat)) {
            $this->getCandidats()->add($candidat);
        }
        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        $this->getCandidats()->removeElement($candidat);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'user')]
    private Collection $commandes;

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        if (!$this->commandes instanceof Collection) {
            $this->commandes = new ArrayCollection();
        }
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->getCommandes()->contains($commande)) {
            $this->getCommandes()->add($commande);
        }
        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        $this->getCommandes()->removeElement($commande);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'user')]
    private Collection $employees;

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

    #[ORM\OneToMany(targetEntity: Rh::class, mappedBy: 'user')]
    private Collection $rhs;

    public function __construct()
    {
        $this->assurances = new ArrayCollection();
        $this->budgets = new ArrayCollection();
        $this->candidats = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->employees = new ArrayCollection();
        $this->rhs = new ArrayCollection();
    }

    /**
     * @return Collection<int, Rh>
     */
    public function getRhs(): Collection
    {
        if (!$this->rhs instanceof Collection) {
            $this->rhs = new ArrayCollection();
        }
        return $this->rhs;
    }

    public function addRh(Rh $rh): self
    {
        if (!$this->getRhs()->contains($rh)) {
            $this->getRhs()->add($rh);
        }
        return $this;
    }

    public function removeRh(Rh $rh): self
    {
        $this->getRhs()->removeElement($rh);
        return $this;
    }

    public function getUserType(): ?string
    {
        return $this->user_type;
    }

    public function setUserType(string $user_type): static
    {
        $this->user_type = $user_type;

        return $this;
    }

}
