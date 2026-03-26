<?php

declare(strict_types=1);

namespace FFTTApi\Model\Joueur;

final class PointsVirtuels
{
    private int $parties = 0;

    private int $victoires = 0;

    private int $defaites = 0;

    private int $forfaits = 0;

    private int $performances = 0;

    private int $contrePerformances = 0;

    private float $estimation = 0.0;

    public function victoire(float $points, bool $isPerformance): self
    {
        $this->victoires++;
        $this->parties++;
        $this->estimation += $points;

        if ($isPerformance) {
            $this->performances++;
        }

        return $this;
    }

    public function defaite(float $points, bool $isContrePerformance): self
    {
        $this->defaites++;
        $this->parties++;
        $this->estimation += $points;

        if ($isContrePerformance) {
            $this->contrePerformances++;
        }

        return $this;
    }

    public function forfait(): self
    {
        $this->forfaits++;
        $this->parties++;

        return $this;
    }

    public function parties(): int
    {
        return $this->parties;
    }

    public function victoires(): int
    {
        return $this->victoires;
    }

    public function defaites(): int
    {
        return $this->defaites;
    }

    public function forfaits(): int
    {
        return $this->forfaits;
    }

    public function performances(): int
    {
        return $this->performances;
    }

    public function contrePerformances(): int
    {
        return $this->contrePerformances;
    }

    public function estimation(): float
    {
        return $this->estimation;
    }
}
