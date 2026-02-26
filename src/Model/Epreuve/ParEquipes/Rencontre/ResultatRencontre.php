<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Rencontre;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class ResultatRencontre implements CanSerialize
{
    private ?string $equipeA;

    private ?string $equipeB;

    private ?int $scoreA;

    private ?int $scoreB;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->equipeA = ValueTransformer::nullOrString($data['equa']);
        $model->equipeB = ValueTransformer::nullOrString($data['equb']);
        $model->scoreA = ValueTransformer::nullOrInt($data['resa']);
        $model->scoreB = ValueTransformer::nullOrInt($data['resb']);

        return $model;
    }

    public function equipeA(): string
    {
        return $this->equipeA;
    }

    public function equipeB(): string
    {
        return $this->equipeB;
    }

    public function scoreEquipeA(): int
    {
        return $this->scoreA;
    }

    public function scoreEquipeB(): int
    {
        return $this->scoreB;
    }
}
