<?php

namespace App\Services;

class PercenTool
{
    public function calculate(int $totalValue1, int $totalValue2): int
    {
        $calculPercent = ($totalValue1 / $totalValue2) * 100;

        return $calculPercent;
    }
}
