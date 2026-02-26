<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\Individuelle;

use Carbon\Carbon;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\DateTimeUtils;

final readonly class Groupe implements CanSerialize
{
    private string $libelle;

    private int $idEpreuve;

    private int $idDivision;

    private int $idGroupe;

    private Carbon $date;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->libelle = $data['libelle'];

        parse_str((string)$data['lien'], $linkParts);

        $model->idEpreuve = (int)$linkParts['epr'];
        $model->idDivision = (int)$linkParts['res_division'];
        $model->idGroupe = (int)$linkParts['cx_tableau'];
        $model->date = DateTimeUtils::date($data['date'], format: 'd/m/Y');

        return $model;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }

    public function idEpreuve(): int
    {
        return $this->idEpreuve;
    }

    public function idDivision(): int
    {
        return $this->idDivision;
    }

    public function idGroupe(): int
    {
        return $this->idGroupe;
    }

    public function date(): Carbon
    {
        return $this->date;
    }
}
