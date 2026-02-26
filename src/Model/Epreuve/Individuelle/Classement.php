<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\Individuelle;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\JoueurUtils;

final readonly class Classement implements CanSerialize
{
    private int $rang;

    private string $nom;

    private string $prenom;

    private bool $numerote;

    private ?int $numero;

    private float $points;

    private string $club;

    private string $pointsCriterium;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->rang = (int)$data['rang'];
        [$model->nom, $model->prenom] = JoueurUtils::separerNomPrenom($data['nom']);
        ['numero' => $model->numero, 'points' => $model->points] = JoueurUtils::parseClassementJoueur($data['clt']);
        $model->numerote = $model->numero !== null;
        $model->club = $data['club'];
        $model->pointsCriterium = $data['points'];

        return $model;
    }

    public function rang(): int
    {
        return $this->rang;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function prenom(): string
    {
        return $this->prenom;
    }

    public function numerote(): bool
    {
        return $this->numerote;
    }

    public function numero(): ?int
    {
        return $this->numero;
    }

    public function points(): float
    {
        return $this->points;
    }

    public function club(): string
    {
        return $this->club;
    }

    public function pointsCriterium(): string
    {
        return $this->pointsCriterium;
    }
}
