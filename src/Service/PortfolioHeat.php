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
            $risk = abs(($position->getEntry() - $position->getStopLoss()) * $this->constants->findValueForInstrument($position->getPosition()));
            $combinedRisk += $risk;
        }

        return $combinedRisk;
    }




}