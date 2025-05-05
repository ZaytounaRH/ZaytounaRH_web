<?php
<<<<<<< HEAD

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\FournisseurRepository;
=======
// src/Entity/Fournisseur.php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Produit;
>>>>>>> origin/manel_gestion_financiere

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
#[ORM\Table(name: 'fournisseur')]
class Fournisseur
{
    #[ORM\Id]
<<<<<<< HEAD
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

=======
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

    #[ORM\Column(name:"nomFournisseur",type: 'string', nullable: false)]
    private ?string $nomFournisseur = null;

=======
>>>>>>> origin/manel_gestion_financiere
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
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $adresse = null;

=======
>>>>>>> origin/manel_gestion_financiere
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

<<<<<<< HEAD
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $contact = null;

=======
>>>>>>> origin/manel_gestion_financiere
    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

<<<<<<< HEAD
    #[ORM\Column(name:"typeService",type: 'string', nullable: true)]
    private ?string $typeService = null;

=======
>>>>>>> origin/manel_gestion_financiere
    public function getTypeService(): ?string
    {
        return $this->typeService;
    }

    public function setTypeService(?string $typeService): self
    {
        $this->typeService = $typeService;
        return $this;
    }

<<<<<<< HEAD
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'fournisseur')]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        if (!$this->produits instanceof Collection) {
            $this->produits = new ArrayCollection();
        }
=======
    public function getProduits(): Collection
    {
>>>>>>> origin/manel_gestion_financiere
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
<<<<<<< HEAD
        if (!$this->getProduits()->contains($produit)) {
            $this->getProduits()->add($produit);
=======
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setFournisseur($this);
>>>>>>> origin/manel_gestion_financiere
        }
        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
<<<<<<< HEAD
        $this->getProduits()->removeElement($produit);
        return $this;
    }

}
=======
        if ($this->produits->removeElement($produit)) {
            if ($produit->getFournisseur() === $this) {
                $produit->setFournisseur(null);
            }
        }
        return $this;
    }
}
>>>>>>> origin/manel_gestion_financiere
