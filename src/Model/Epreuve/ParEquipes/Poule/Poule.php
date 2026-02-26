<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Poule;

use FFTTApi\Model\CanSerialize;

final readonly class Poule implements CanSerialize
{
    private string $libelle;

    private int $idPoule;

    private int $idDivision;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->libelle = $data['libelle'];

        parse_str((string)$data['lien'], $linkParts);

        $model->idPoule = (int)$linkParts['cx_poule'];
        $model->idDivision = (int)$linkParts['D1'];

        return $model;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }

    public function idPoule(): int
    {
        return $this->idPoule;
    }

    public function idDivision(): int
    {
        return $this->idDivision;
    }
}
