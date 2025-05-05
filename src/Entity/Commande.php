<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ORM\Table(name: 'commande')]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: "dateCommande", type: 'date', nullable: false)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    private ?int $quantite = null;

    #[ORM\Column(name: "statutCommande", type: 'string', nullable: false)]
    #[Assert\Choice(choices: [
        'En attente',
        'Accepté',
        'Annulée'
    ], message: "Veuillez choisir un type de service valide.")]
    private ?string $statutCommande = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class)]
    #[ORM\JoinColumn(name: 'idFournisseur', referencedColumnName: 'id', nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'idResponsable', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $description = null;

    #[ORM\Column(name: "prixCommande", type: 'decimal', nullable: true)]
    #[Assert\Type(type: 'numeric', message: 'Le prix doit être un nombre valide.')]
    private ?float $prixCommande = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getStatutCommande(): ?string
    {
        return $this->statutCommande;
    }

    public function setStatutCommande(string $statutCommande): self
    {
        $this->statutCommande = $statutCommande;
        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrixCommande(): ?float
    {
        return $this->prixCommande;
    }

    public function setPrixCommande(?float $prixCommande): self
    {
        $this->prixCommande = $prixCommande;
        return $this;
    }
}