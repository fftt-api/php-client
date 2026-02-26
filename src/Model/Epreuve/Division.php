<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve;

use FFTTApi\Model\CanSerialize;

final readonly class Division implements CanSerialize
{
    private int $id;

    private string $libelle;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->id = (int)$data['iddivision'];
        $model->libelle = $data['libelle'];

        return $model;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }
}
