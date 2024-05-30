<?php declare(strict_types=1);

namespace App\Constant;

use ReflectionClass;

class PipPerLotValueConstants
{


    public const US_STOCKS = 1;
    public const PLATINUM = 100;

    public function findValueForInstrument(string $instrument): int
    {
        // Use reflection to get all constants in this class
        $reflection = new ReflectionClass($this);
        $constants = $reflection->getConstants();

        // Iterate through the constants and find the value for the given instrument
        foreach ($constants as $key => $value) {
            if ($key === $instrument) {
                return $value;
            }
        }

        // Handle the case where the instrument is not found
        throw new \InvalidArgumentException('Unknown instrument: ' . $instrument);
    }

}

