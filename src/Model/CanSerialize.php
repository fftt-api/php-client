<?php

declare(strict_types=1);

namespace FFTTApi\Model;

interface CanSerialize
{
    public static function fromArray(array $data): self;
}
