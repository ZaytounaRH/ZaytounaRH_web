<?php
<<<<<<< HEAD

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\ProduitRepository;
=======
// src/Entity/Produit.php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
>>>>>>> origin/manel_gestion_financiere

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: 'produit')]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

<<<<<<< HEAD
=======
    #[ORM\Column(name: "produitName", type: 'string', nullable: false)]
    private ?string $produitName = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private ?float $prix = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idFournisseur', referencedColumnName: 'id', nullable: true)]
    private ?Fournisseur $fournisseur = null;

    

>>>>>>> origin/manel_gestion_financiere
    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Column(name:"produitName",type: 'string', nullable: false)]
    private ?string $produitName = null;

=======
>>>>>>> origin/manel_gestion_financiere
    public function getProduitName(): ?string
    {
        return $this->produitName;
    }

    public function setProduitName(string $produitName): self
    {
        $this->produitName = $produitName;
        return $this;
    }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    private ?string $nomFournisseur = null;

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(string $nomFournisseur): self
    {
        $this->nomFournisseur = $nomFournisseur;
        return $this;
    }
=======
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence

    #[ORM\Column(type: 'decimal', nullable: false)]
    private ?float $prix = null;
=======
>>>>>>> origin/manel_gestion_financiere

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    
=======
=======
>>>>>>> origin/asma_gestion_presence
    #[ORM\Column(name:"produitName",type: 'string', nullable: false)]
    private ?string $nomFournisseur = null;

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(string $nomFournisseur): self
    {
        $this->nomFournisseur = $nomFournisseur;
        return $this;
    }
<<<<<<< HEAD
>>>>>>> origin/ons_gestion_recrutement
=======
>>>>>>> origin/asma_gestion_presence

    #[ORM\ManyToOne(targetEntity: Fournisseur::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idFournisseur', referencedColumnName: 'id')]
    private ?Fournisseur $fournisseur = null;

=======
>>>>>>> origin/manel_gestion_financiere
    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;
        return $this;
    }

<<<<<<< HEAD
}
=======
    public function getNomFournisseur(): ?string
    {
        return $this->fournisseur ? $this->fournisseur->getNomFournisseur() : null;
    }
}
>>>>>>> origin/manel_gestion_financiere
