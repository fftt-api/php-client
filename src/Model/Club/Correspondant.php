<?php

declare(strict_types=1);

namespace FFTTApi\Model\Club;

final readonly class Correspondant
{
    public function __construct(
        public string $nom,
        public string $prenom,
        public string $email,
        public string $telephone,
    ) {
    }
}
