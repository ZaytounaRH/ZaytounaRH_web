<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\CandidatRepository;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
#[ORM\Table(name: 'candidat')]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $candidat_id = null;
    public function getId(): ?int
    {
        return $this->candidat_id;
    }
    public function getCandidat_id(): ?int
    {
        return $this->candidat_id;
    }

    public function setCandidat_id(int $candidat_id): self
    {
        $this->candidat_id = $candidat_id;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'candidats')]
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

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $status = null;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Entretien::class, mappedBy: 'candidat')]
    private Collection $entretiens;

    public function __construct()
    {
        $this->entretiens = new ArrayCollection();
    }

    /**
     * @return Collection<int, Entretien>
     */
    public function getEntretiens(): Collection
    {
        if (!$this->entretiens instanceof Collection) {
            $this->entretiens = new ArrayCollection();
        }
        return $this->entretiens;
    }

    public function addEntretien(Entretien $entretien): self
    {
        if (!$this->getEntretiens()->contains($entretien)) {
            $this->getEntretiens()->add($entretien);
        }
        return $this;
    }

    public function removeEntretien(Entretien $entretien): self
    {
        $this->getEntretiens()->removeElement($entretien);
        return $this;
    }

    public function getCandidatId(): ?int
    {
        return $this->candidat_id;
    }

}