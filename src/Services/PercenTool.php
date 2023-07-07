<?php

namespace App\Services;

use App\Entity\Category;

class PercenTool
{
    public function getScore(Category $category): int
    {
        $score = 0;
        $tutorials = $category->getTutorials();
        foreach ($tutorials as $tutorial) {
            $progress = $tutorial->getProgress();
            foreach ($progress as $result) {
                if ($result->getScore() >= 4) {
                    $score++;
                }
            }
        }
        return $score;
    }

    public function calculatePercentage(Category $category): int
    {
        $score = $this->getScore($category);
        $tutorials = $category->getTutorials();
        $totalTutorials = count($tutorials);
        $calculPercent = ($score / $totalTutorials) * 100;
        return $calculPercent;
    }
}
