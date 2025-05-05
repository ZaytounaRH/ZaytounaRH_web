<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: 'reclamation')]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idR', type: 'integer')]
    private ?int $idR = null;

    #[ORM\Column(name: 'titre', type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(min: 3, max: 100, minMessage: 'Le titre doit contenir au moins {{ limit }} caractères.')]
    private ?string $titre = null;

    #[ORM\Column(name: 'description', type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'La description est obligatoire.')]
    #[Assert\Length(min: 10, minMessage: 'La description doit contenir au moins {{ limit }} caractères.')]
    private ?string $description = null;

    #[ORM\Column(name: 'incidentType', type: 'string', nullable: false)]
#[Assert\NotBlank(message: 'Le type d\'incident est obligatoire.')]
#[Assert\Choice(choices: ['ACCIDENT_TRAVAIL', 'MALADIE_PROFESSIONNELLE', 'DÉFAUT_COUVERTURE', 'LITIGE_CONTRAT'], message: 'Type d\'incident invalide.')]
private ?string $incidentType = null;



    #[ORM\Column(name: 'dateSoumission', type: 'date', nullable: false)]
    #[Assert\NotNull(message: 'La date de soumission est obligatoire.')]
    #[Assert\LessThanOrEqual('today', message: 'La date de soumission ne peut pas être dans le futur.')]
    private ?\DateTimeInterface $dateSoumission = null;

    #[ORM\Column(name: 'statut', type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Le statut est obligatoire.')]
    #[Assert\Choice(choices: ['EN_ATTENTE', 'EN_COURS', 'RESOLU'], message: 'Statut invalide.')]
    private ?string $statut = null;

    #[ORM\Column(name: 'priorite', type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'La priorité est obligatoire.')]
    #[Assert\Choice(choices: ['FAIBLE', 'MOYENNE', 'ELEVEE'], message: 'Priorité invalide.')]
    private ?string $priorite = null;


    #[ORM\ManyToOne(targetEntity: Assurance::class, inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: 'idAssurance', referencedColumnName: 'idA')]
    #[Assert\NotNull(message: 'L\'assurance liée est obligatoire.')]
    private ?Assurance $assurance = null;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: 'reclamation')]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getIdR(): ?int
    {
        return $this->idR;
    }

    public function setIdR(int $idR): self
    {
        $this->idR = $idR;
        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getIncidentType(): ?string
    {
        return $this->incidentType;
    }

    public function setIncidentType(string $incidentType): self
    {
        $this->incidentType = $incidentType;
        return $this;
    }

    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(\DateTimeInterface $dateSoumission): self
    {
        $this->dateSoumission = $dateSoumission;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): self
    {
        $this->priorite = $priorite;
        return $this;
    }

    

    public function getAssurance(): ?Assurance
    {
        return $this->assurance;
    }

    public function setAssurance(?Assurance $assurance): self
    {
        $this->assurance = $assurance;
        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
        }
        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        $this->reponses->removeElement($reponse);
        return $this;
    }
    public function getId(): ?int
{
    return $this->idR;
}

}
