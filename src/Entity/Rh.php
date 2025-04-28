<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\RhRepository;

#[ORM\Entity(repositoryClass: RhRepository::class)]
#[ORM\Table(name: 'rh')]
class Rh
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $rh_id = null;
    public function getId(): ?int
    {
        return $this->rh_id;
    }
    public function getRh_id(): ?int
    {
        return $this->rh_id;
    }

    public function setRh_id(int $rh_id): self
    {
        $this->rh_id = $rh_id;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rhs')]
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

    #[ORM\OneToMany(targetEntity: Conge::class, mappedBy: 'rh')]
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

    #[ORM\OneToMany(targetEntity: Offreemploi::class, mappedBy: 'rh')]
    private Collection $offreemplois;

    /**
     * @return Collection<int, Offreemploi>
     */
    public function getOffreemplois(): Collection
    {
        if (!$this->offreemplois instanceof Collection) {
            $this->offreemplois = new ArrayCollection();
        }
        return $this->offreemplois;
    }

    public function addOffreemploi(Offreemploi $offreemploi): self
    {
        if (!$this->getOffreemplois()->contains($offreemploi)) {
            $this->getOffreemplois()->add($offreemploi);
        }
        return $this;
    }

    public function removeOffreemploi(Offreemploi $offreemploi): self
    {
        $this->getOffreemplois()->removeElement($offreemploi);
        return $this;
    }

    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'rh')]
    private Collection $presences;

    public function __construct()
    {
        $this->conges = new ArrayCollection();
        $this->offreemplois = new ArrayCollection();
        $this->presences = new ArrayCollection();
    }

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

    public function getRhId(): ?int
    {
        return $this->rh_id;
    }

}
