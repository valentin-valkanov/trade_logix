<?php declare(strict_types=1);

namespace App\Service;

use App\Constant\PipPerLotValueConstants;
use App\Entity\PortfolioHeatMetrics;
use App\Repository\PositionRepository;
use Doctrine\ORM\EntityManagerInterface;

class PortfolioHeat
{
private array $closedPositions;
private array $openPositions;


    public function __construct(
        private PositionRepository $positionRepository,
        private PipPerLotValueConstants $constants,
        private EntityManagerInterface $entityManager
    )
    {
        $this->closedPositions = $this->positionRepository->findPositionsForCurrentWeek();
        $this->openPositions = $this->positionRepository->findOpenPositions();
    }

    public function findCombinedRisk()
    {
        $combinedRisk = 0;
        foreach ($this->openPositions as $position){
            $value = $this->constants->findValueForInstrument($position->getSymbol());
            $risk = abs(($position->getEntry() - $position->getStopLoss()) * $value);
            $combinedRisk += $risk;
        }

        return $combinedRisk;
    }

    public function findCombinedRiskPercent(float $accountBalance): float
    {
        $combinedRiskUSD = $this->findCombinedRisk();
        return ($combinedRiskUSD / $accountBalance) * 100;
    }

    public function findTotalOpenPositions(): int
    {
        return count($this->openPositions);
    }

    public function getClosedPnL()
    {
        $weeklyPnL = 0;
        foreach ($this->closedPositions as $position){
            $weeklyPnL += $position->getProfit();
        }

        return $weeklyPnL;
    }

    public function getOpenPnL()
    {
        $floatingPnL = 0;
        foreach ($this->openPositions as $position){
            $floatingPnL += $position->getProfit();
        }

        return $floatingPnL;
    }

    public function saveDailyMetrics()
    {
        $account = 10000;
        $combinedRisk = $this->findCombinedRisk();
        $combinedRiskPercent = $this->findCombinedRiskPercent($account);
        $totalOpenPositions = $this->findTotalOpenPositions();
        $newTrades = count($this->positionRepository->findNewTrades());
        $closedTrades = count($this->positionRepository->findPositionsForCurrentWeek());
        $closedPnL = $this->getClosedPnL();
        $openPnL = $this->getOpenPnL();
        $account = $account + $closedPnL;

        $metrics = new PortfolioHeatMetrics();
        $metrics->setDate(new \DateTime());
        $metrics->setCombinedRisk($combinedRisk);
        $metrics->setCombinedRiskPercent($combinedRiskPercent);
        $metrics->setTotalOpenPositions($totalOpenPositions);
        $metrics->setNewTrades($newTrades);
        $metrics->setClosedPositions($closedTrades);
        $metrics->setClosedPnL($closedPnL);
        $metrics->setOpenPnL($openPnL);
        $metrics->setAccount($account);

        $this->entityManager->persist($metrics);
        $this->entityManager->flush();
    }
}