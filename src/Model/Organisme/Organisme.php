<?php

declare(strict_types=1);

namespace FFTTApi\Model\Organisme;

use FFTTApi\Enum\TypeOrganisme;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class Organisme implements CanSerialize
{
    private int $id;

    private string $libelle;

    private string $code;

    private ?int $idOrganismeParent;

    private TypeOrganisme $type;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->id = (int)$data['id'];
        $model->libelle = $data['libelle'];
        $model->code = $data['code'];
        $model->idOrganismeParent = ValueTransformer::nullOrInt($data['idPere']);
        $model->type = TypeOrganisme::from(mb_substr((string)$data['code'], 0, 1));

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

    public function code(): string
    {
        return $this->code;
    }

    public function idOrganismeParent(): ?int
    {
        return $this->idOrganismeParent;
    }

    public function type(): TypeOrganisme
    {
        return $this->type;
    }
}
