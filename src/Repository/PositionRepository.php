<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Position>
 */
class PositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    /**
     * Get positions for the current week
     *
     * @return Position[]
     */
    public function findPositionsForCurrentWeek(): array
    {
        $qb = $this->createQueryBuilder('p');

        $startOfWeek = new \DateTime();
        $startOfWeek->setISODate((int)date('Y'), (int)date('W'));
        $startOfWeek->setTime(0, 0, 0);

        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('+6 days');
        $endOfWeek->setTime(23, 59, 59);

        return $qb
            ->where('p.exitTime IS NOT NULL')
            ->andWhere('p.exitTime BETWEEN :startOfWeek AND :endOfWeek')
            ->setParameter('startOfWeek', $startOfWeek)
            ->setParameter('endOfWeek', $endOfWeek)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get open positions
     *
     * @return Position[]
     */
    public function findOpenPositions(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.exitTime IS NULL')
            ->getQuery()
            ->getResult();
    }
}
