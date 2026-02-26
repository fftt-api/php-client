<?php

declare(strict_types=1);

namespace FFTTApi\Model\Divers;

use FFTTApi\Model\CanSerialize;

final readonly class Initialisation implements CanSerialize
{
    private bool $appli;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->appli = (bool)$data['appli'];

        return $model;
    }

    public function appli(): bool
    {
        return $this->appli;
    }
}
