<?php

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fournisseur>
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }

    /**
     * Rechercher des fournisseurs par leur nom.
     *
     * @param string $search Le terme de recherche.
     * @return Fournisseur[] Liste des fournisseurs correspondants.
     */
    public function findBySearch(string $search)
    {
        $qb = $this->createQueryBuilder('f');
    
        // Si un terme de recherche est donné, on ajoute une condition LIKE pour filtrer par nomFournisseur
        if (!empty($search)) {
            $qb->andWhere('f.nomFournisseur LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
    
        // Optionnel : Tri des résultats par nom (à ajuster selon ton besoin)
        $qb->orderBy('f.nomFournisseur', 'ASC');
    
        return $qb->getQuery()->getResult();
    }
    
}
