<?php

namespace App\Repository;

use App\Entity\PortfolioHeatMetrics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioHeatMetrics>
 */
class PortfolioHeatMetricsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioHeatMetrics::class);
    }

    public function findMetricsForCurrentWeek(): array
    {
        $qb = $this->createQueryBuilder('phm');
        [$startOfWeek, $endOfWeek] = $this->getCurrentWeekRange();

        return $qb
            ->where('phm.date BETWEEN :startOfWeek AND :endOfWeek')
            ->setParameter('startOfWeek', $startOfWeek)
            ->setParameter('endOfWeek', $endOfWeek)
            ->orderBy('phm.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByDate(\DateTimeInterface $date): ?PortfolioHeatMetrics
    {
        return $this->createQueryBuilder('phm')
            ->andWhere('phm.date = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public static function getCurrentWeekRange(): array
    {
        $startOfWeek = new \DateTime();
        $startOfWeek->setISODate((int)date('Y'), (int)date('W'));
        $startOfWeek->setTime(0, 0, 0);

        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('+6 days');
        $endOfWeek->setTime(23, 59, 59);

        return [$startOfWeek, $endOfWeek];
    }


}
