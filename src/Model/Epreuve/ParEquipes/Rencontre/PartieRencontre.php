<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Rencontre;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ScoreUtils;
use FFTTApi\Util\ValueTransformer;

final readonly class PartieRencontre implements CanSerialize
{
    private ?string $joueurA;

    private ?string $joueurB;

    private ?int $scoreA;

    private ?int $scoreB;

    /** @var array<int> */
    private array $detailManches;

    /** @var array<array-key, array<int>> */
    private array $detailManchesComplet;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->joueurA = ValueTransformer::nullOrString($data['ja']);
        $model->joueurB = ValueTransformer::nullOrString($data['jb']);
        $model->scoreA = $data['scorea'] === '-' ? 0 : (int)$data['scorea'];
        $model->scoreB = $data['scoreb'] === '-' ? 0 : (int)$data['scoreb'];
        $model->detailManches = array_map(
            static fn (string $score): int => (int)$score,
            explode(' ', $data['detail'])
        );
        $model->detailManchesComplet = ScoreUtils::detaillerScores($model->detailManches);

        return $model;
    }

    public function joueurA(): ?string
    {
        return $this->joueurA;
    }

    public function joueurB(): ?string
    {
        return $this->joueurB;
    }

    public function scoreA(): ?int
    {
        return $this->scoreA;
    }

    public function scoreB(): ?int
    {
        return $this->scoreB;
    }

    /** @return array<int> */
    public function detailManches(): array
    {
        return $this->detailManches;
    }

    /** @return array<array-key, array<int>> */
    public function detailManchesComplet(): array
    {
        return $this->detailManchesComplet;
    }
}
