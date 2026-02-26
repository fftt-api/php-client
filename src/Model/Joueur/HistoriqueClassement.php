<?php

declare(strict_types=1);

namespace FFTTApi\Model\Joueur;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class HistoriqueClassement implements CanSerialize
{
    private bool $numerote;

    private ?int $numero;

    private float $pointsOfficiels;

    private string $saison;

    private int $phase;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->numerote = ValueTransformer::exists($data['echelon']);
        $model->numero = ValueTransformer::nullOrInt($data['place']);
        $model->pointsOfficiels = (float)$data['point'];
        $model->saison = $data['saison'];
        $model->phase = (int)$data['phase'];

        return $model;
    }

    public function numerote(): bool
    {
        return $this->numerote;
    }

    public function numero(): ?int
    {
        return $this->numero;
    }

    public function pointsOfficiels(): float
    {
        return $this->pointsOfficiels;
    }

    public function saison(): string
    {
        return $this->saison;
    }

    public function phase(): int
    {
        return $this->phase;
    }
}
