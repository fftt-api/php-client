<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve;

use FFTTApi\Enum\TypeEpreuve;
use FFTTApi\Model\CanSerialize;

final readonly class Epreuve implements CanSerialize
{
    private int $idEpreuve;

    private int $idOrganisme;

    private string $libelle;

    private TypeEpreuve $type;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->idEpreuve = (int)$data['idepreuve'];
        $model->idOrganisme = (int)$data['idorga'];
        $model->libelle = $data['libelle'];
        $model->type = TypeEpreuve::from($data['typepreuve']);

        return $model;
    }

    public function idEpreuve(): int
    {
        return $this->idEpreuve;
    }

    public function idOrganisme(): int
    {
        return $this->idOrganisme;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }

    public function type(): TypeEpreuve
    {
        return $this->type;
    }
}
