<?php declare(strict_types=1);

namespace App\Service;

use App\Constant\PipPerLotValueConstants;
use App\Repository\PositionRepository;

class PortfolioHeat
{
private array $closedPositions;
private array $openPositions;


    public function __construct(private PositionRepository $positionRepository, private PipPerLotValueConstants $constants)
    {
        $this->closedPositions = $this->positionRepository->findPositionsForCurrentWeek();
        $this->openPositions = $this->positionRepository->findOpenPositions();
    }

    public function findCombinedRisk()
    {
        $combinedRisk = 0;
        foreach ($this->openPositions as $position){
            $risk = abs(($position->getEntry() - $position->getStopLoss()) * $this->constants->findValueForInstrument($position->getSymbol()));
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
}