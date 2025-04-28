<?php
// src/Entity/Fournisseur.php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Produit;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
#[ORM\Table(name: 'fournisseur')]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: "nomFournisseur", type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le nom du fournisseur est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÿ]+$/", 
        message: "Le nom du fournisseur ne doit contenir que des lettres."
    )]
    private ?string $nomFournisseur = null;

    #[ORM\Column(type: 'text', nullable: false)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire.")]
    private ?string $adresse = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Regex(
        pattern: "/^[0-9]{8}$/", 
        message: "Le contact doit contenir exactement 8 chiffres."
    )]
    private ?string $contact = null;

    #[ORM\Column(name: "typeService", type: 'string', nullable: true)]
    #[Assert\Choice(choices: [
        'TRANSPORT',
        'BANK',
        'ELECTRONIQUE',
        'NOURRITURE',
        'INFORMATIQUE',
        'MEUBLE'
    ], message: "Veuillez choisir un type de service valide.")]
    private ?string $typeService = null;

    #[ORM\OneToMany(mappedBy: "fournisseur", targetEntity: Produit::class, cascade: ['persist', 'remove'])]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(string $nomFournisseur): self
    {
        $this->nomFournisseur = $nomFournisseur;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

    public function getTypeService(): ?string
    {
        return $this->typeService;
    }

    public function setTypeService(?string $typeService): self
    {
        $this->typeService = $typeService;
        return $this;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setFournisseur($this);
        }
        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getFournisseur() === $this) {
                $produit->setFournisseur(null);
            }
        }
        return $this;
    }
}
