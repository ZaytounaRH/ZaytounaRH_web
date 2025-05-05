<?php
namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function findByBudgetAndStatus($budgetId, $status)
    {
        return $this->createQueryBuilder('c')
            ->join('c.budget', 'b') // Joindre la relation entre Commande et Budget
            ->andWhere('b.id = :budgetId')
            ->andWhere('c.statutCommande = :status')
            ->setParameter('budgetId', $budgetId)
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }

    // Méthode pour obtenir la somme des commandes d'un budget avec un statut donné
    public function getTotalCommandesForBudget($budgetId, $status): float
    {
        $qb = $this->createQueryBuilder('c')
            ->select('SUM(c.prixCommande) as total') // Calcul de la somme des prix des commandes
            ->join('c.budget', 'b') // Joindre la relation entre Commande et Budget
            ->andWhere('b.id = :budgetId')
            ->andWhere('c.statutCommande = :status')
            ->setParameter('budgetId', $budgetId)
            ->setParameter('status', $status)
            ->getQuery();

        $result = $qb->getSingleScalarResult(); // Récupérer le résultat de la somme

        return (float) $result; // Retourner la somme sous forme de nombre flottant
    }
}
