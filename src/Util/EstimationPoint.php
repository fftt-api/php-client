<?php

declare(strict_types=1);

namespace FFTTApi\Util;

final readonly class EstimationPoint
{
    /**
     * Barème des points gagnés/perdus en fonction de la différence de classement.
     *
     * @var array<string, array{0: float, 1: float}> élément 1 : points gagnés, élément 2 : points perdus
     */
    private const array BAREME = [
        -500 => [40, 0],
        -400 => [28, 0],
        -300 => [22, -0.5],
        -200 => [17, -1],
        -150 => [13, -2],
        -100 => [10, -3],
        -50 => [8, -4],
        -25 => [7, -4.5],
        0 => [6, -5],
        25 => [6, -5],
        50 => [5.5, -6],
        100 => [5, -7],
        150 => [4, -8],
        200 => [3, -10],
        300 => [2, -12.5],
        400 => [1, -16],
        500 => [0.5, -20],
    ];

    public static function estimer(
        float $classementJoueurA,
        float $classementJoueurB,
        bool  $victoire = true,
        float $coefficient = 1.0,
    ): float {
        $differenceClassement = $classementJoueurA - $classementJoueurB;

        foreach (self::BAREME as $classement => $points) {
            if ($differenceClassement <= $classement) {
                return $points[$victoire ? 0 : 1] * $coefficient;
            }
        }

        if ($victoire) {
            return 0;
        }

        return -29 * $coefficient;
    }
}
