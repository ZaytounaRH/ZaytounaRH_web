<?php

namespace App\Repository;
use App\Entity\Employee;
use App\Entity\Presence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Presence>
 */
class PresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Presence::class);
    }

    //    /**
    //     * @return Presence[] Returns an array of Presence objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Presence
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function searchAndSort(?string $search, string $sort, string $direction): array
{
    $qb = $this->createQueryBuilder('p');

    if ($search) {
        $qb->andWhere('p.date LIKE :search OR p.heureArrive LIKE :search OR p.heureDepart LIKE :search')
           ->setParameter('search', '%' . $search . '%');
    }

    if (!in_array($sort, ['date', 'heureArrive', 'heureDepart'])) {
        $sort = 'date';
    }

    if (!in_array(strtolower($direction), ['asc', 'desc'])) {
        $direction = 'asc';
    }

    $qb->orderBy('p.' . $sort, $direction);

    return $qb->getQuery()->getResult();
}

public function findEmployeesWith3ConsecutiveLateDays(): array
{
    $today = new \DateTimeImmutable('today');
    
    // On récupère les 3 derniers jours (au format DateTime, pas string)
    $day1 = $today;
$day2 = $day1->sub(new \DateInterval('P1D'));
$day3 = $day2->sub(new \DateInterval('P1D'));

$dates = ['2025-04-24', '2025-04-25', '2025-04-26'];

    // On récupère les présences en retard sur ces 3 jours
    $retards = $this->createQueryBuilder('p')
        ->select('IDENTITY(p.employee) as empId', 'p.date')
        ->where('p.date IN (:dates)')
        ->andWhere('p.heureArrive IS NULL OR p.heureArrive > :lateTime')
        ->setParameter('dates', $dates)
        ->setParameter('lateTime', new \DateTime('09:00:00'))
        ->getQuery()
        ->getArrayResult();

    // Regrouper par employé
    $retardsParEmploye = [];

    foreach ($retards as $retard) {
        $empId = $retard['empId'];
        $date = $retard['date']->format('Y-m-d');
        $retardsParEmploye[$empId][] = $date;
    }

    // Filtrer les employés ayant 3 jours de retard sur les 3 dates spécifiées
    $retardatairesIds = [];
    foreach ($retardsParEmploye as $empId => $datesRetard) {
        if (count(array_unique($datesRetard)) === 3) {
            $retardatairesIds[] = $empId;
        }
    }

    if (empty($retardatairesIds)) {
        return [];
    }

    // Récupérer les objets Employee à partir de leur ID
    return $this->getEntityManager()->getRepository(Employee::class)
        ->createQueryBuilder('e')
        ->innerJoin('e.user', 'u') // pour afficher prénom et nom dans Twig
        ->where('e.employee_id IN (:ids)')
        ->setParameter('ids', $retardatairesIds)
        ->getQuery()
        ->getResult();
}

// ✅ Nombre de présences par mois
public function countPresencesPerMonth($year): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT MONTH(p.date) AS month, COUNT(*) AS count
        FROM presence p
        WHERE YEAR(p.date) = :year
        GROUP BY month
        ORDER BY month ASC
    ";

    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery(['year' => $year]);

    return $resultSet->fetchAllAssociative();
}


// ✅ Nombre total de retards
public function countTotalRetards(): int
{
    return (int) $this->createQueryBuilder('p')
        ->select('COUNT(p.id_presence)')
        ->where('p.heureArrive IS NULL OR p.heureArrive > :lateTime')
        ->setParameter('lateTime', new \DateTime('09:00:00'))
        ->getQuery()
        ->getSingleScalarResult();
}

// ✅ Moyenne d'heures travaillées par jour
public function averageWorkedHoursPerDay(): float
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT AVG(TIMESTAMPDIFF(SECOND, heureArrive, heureDepart)) AS avgSeconds
        FROM presence
        WHERE heureArrive IS NOT NULL AND heureDepart IS NOT NULL
    ";

    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery()->fetchOne();

    return $result ? round($result / 3600, 2) : 0; // conversion secondes → heures
}







}
