<?php
// src/Entity/Produit.php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: 'produit')]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: "produitName", type: 'string', nullable: false)]
    private ?string $produitName = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private ?float $prix = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idFournisseur', referencedColumnName: 'id', nullable: true)]
    private ?Fournisseur $fournisseur = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduitName(): ?string
    {
        return $this->produitName;
    }

    public function setProduitName(string $produitName): self
    {
        $this->produitName = $produitName;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
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

    public function getNomFournisseur(): ?string
    {
        return $this->fournisseur ? $this->fournisseur->getNomFournisseur() : null;
    }
}
