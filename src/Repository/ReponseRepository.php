<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reponse>
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    /**
     * Récupérer toutes les réponses triées par dateRep décroissant
     */
    public function findAllOrderByDateRepDesc(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.dateRep', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // src/Repository/ReponseRepository.php
    public function findAllOrderByDateRepDescPaginated($page, $limit = 10)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.dateRep', 'DESC')
            ->getQuery()
            ->setFirstResult(($page - 1) * $limit) // Calcul de l'offset
            ->setMaxResults($limit) // Limite du nombre de résultats
            ->getResult();
    }



    //    /**
    //     * @return Reponse[] Returns an array of Reponse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reponse
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
