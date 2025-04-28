<?php

namespace App\Repository;

use App\Entity\Conge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conge>
 */
class CongeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conge::class);
    }

    // ✅ Nombre de jours de congés posés
    public function countTotalConges(string $year): int
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT SUM(DATEDIFF(dateFin, dateDebut) + 1) AS total_conges
        FROM conge
        WHERE YEAR(dateDebut) = :year
        AND statut != 'REFUSE'
    ";

    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery(['year' => $year])->fetchOne();

    return $result ? (int) $result : 0;
}

    


    //    /**
    //     * @return Conge[] Returns an array of Conge objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conge
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
