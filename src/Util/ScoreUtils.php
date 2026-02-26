<?php

declare(strict_types=1);

namespace FFTTApi\Util;

final class ScoreUtils
{
    /**
     * @param array<int> $scores
     *
     * @return int[][]
     *
     * @psalm-return list{0?: list{int<0, max>, int<0, max>},...}
     */
    public static function detaillerScores(array $scores): array
    {
        $scoresDetailles = [];

        foreach ($scores as $score) {
            if ($score < 0 && $score >= -9) {
                /** Si c'est une manche perdue aux avantages. */
                $scoresDetailles[] = [abs($score), 11];
            } elseif ($score < 0 && $score < -9) {
                /** Si c'est une manche perdue avant les avantages. */
                $scoresDetailles[] = [abs($score), abs($score) + 2];
            } elseif ($score >= 0 && $score < 10) {
                /** Si c'est une manche gagnée avant les avantages. */
                $scoresDetailles[] = [11, abs($score)];
            } else {
                /** Si c'est une manche gagnée aux avantages. */
                $scoresDetailles[] = [abs($score) + 2, abs($score)];
            }
        }

        return $scoresDetailles;
    }
}
