<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclamation>
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    /**
     * Trouver des réclamations par type d'incident
     */
    public function findByIncidentType(string $incidentType): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.incidentType = :incidentType')
            ->setParameter('incidentType', $incidentType)
            ->getQuery()
            ->getResult();
    }
}
