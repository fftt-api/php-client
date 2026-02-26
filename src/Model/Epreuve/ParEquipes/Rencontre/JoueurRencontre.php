<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Rencontre;

use FFTTApi\Enum\Sexe;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\JoueurUtils;

final readonly class JoueurRencontre implements CanSerialize
{
    private ?string $joueurA;

    private ?string $joueurB;

    private ?float $pointsOfficielsA;

    private ?float $pointsOfficielsB;

    private ?int $rangNationalA;

    private ?int $rangNationalB;

    private ?Sexe $sexeA;

    private ?Sexe $sexeB;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->joueurA = $data['xja'];
        $model->joueurB = $data['xjb'];

        $classementA = JoueurUtils::parseClassementJoueur($data['xca']);
        $model->rangNationalA = $classementA['numero'];
        $model->sexeA = $classementA['sexe'];
        $model->pointsOfficielsA = $classementA['points'];

        $classementB = JoueurUtils::parseClassementJoueur($data['xcb']);
        $model->rangNationalB = $classementB['numero'];
        $model->sexeB = $classementB['sexe'];
        $model->pointsOfficielsB = $classementB['points'];

        return $model;
    }

    public function joueurA(): ?string
    {
        return $this->joueurA;
    }

    public function joueurB(): ?string
    {
        return $this->joueurB;
    }

    public function pointsOfficielsA(): ?float
    {
        return $this->pointsOfficielsA;
    }

    public function pointsOfficielsB(): ?float
    {
        return $this->pointsOfficielsB;
    }

    public function rangNationalA(): ?int
    {
        return $this->rangNationalA;
    }

    public function rangNationalB(): ?int
    {
        return $this->rangNationalB;
    }

    public function sexeA(): ?Sexe
    {
        return $this->sexeA;
    }

    public function sexeB(): ?Sexe
    {
        return $this->sexeB;
    }
}
