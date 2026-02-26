<?php

declare(strict_types=1);

namespace FFTTApi\Model\Club;

use Carbon\Carbon;
use FFTTApi\Enum\TypeClub;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final class Club implements CanSerialize
{
    private string $id;

    private string $numero;

    private string $nom;

    private ?Carbon $validation = null;

    private TypeClub $type;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->id = $data['idclub'];
        $model->numero = $data['numero'];
        $model->nom = $data['nom'];
        $model->validation = ValueTransformer::nullOrDate($data['validation'], format: 'd/m/Y');
        $model->type = TypeClub::from($data['typeclub']);

        return $model;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function numero(): string
    {
        return $this->numero;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function dateValidation(): ?Carbon
    {
        return $this->validation;
    }

    public function type(): TypeClub
    {
        return $this->type;
    }
}
