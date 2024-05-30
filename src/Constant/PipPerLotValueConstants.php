<?php declare(strict_types=1);

namespace App\Constant;

use ReflectionClass;

class PipPerLotValueConstants
{


    public const US_STOCKS = 1;
    public const PLATINUM = 100;
    public const BTCUSD = 1;

    public const GOLD = 10;

    public function findValueForInstrument(string $instrument): int
    {

        $reflection = new ReflectionClass($this);
        $constants = $reflection->getConstants();


        foreach ($constants as $key => $value) {
            if ($key === $instrument) {
                return $value;
            }
        }

        throw new \InvalidArgumentException('Unknown instrument: ' . $instrument);
    }

}

