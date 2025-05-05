<?php

// src/Repository/ProduitRepository.php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * Recherche des produits en fonction du nom.
     *
     * @param string $search Le terme de recherche
     * @return Produit[] Un tableau d'objets Produit
     */
    public function findBySearch(string $search): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.produitName LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery();

        return $qb->getResult();
    }
}
