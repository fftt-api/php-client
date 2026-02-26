<?php

declare(strict_types=1);

namespace FFTTApi\Model\Joueur;

use FFTTApi\Enum\Sexe;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class JoueurBaseSPID implements CanSerialize
{
    private string $licence;

    private string $nom;

    private string $prenom;

    private ?string $club;

    private ?string $numeroClub;

    private Sexe $sexe;

    private bool $numerote;

    private ?int $numero;

    private float $pointsOfficiels;

    private int $classementOfficiel;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->licence = $data['licence'];
        $model->nom = $data['nom'];
        $model->prenom = $data['prenom'];
        $model->club = ValueTransformer::nullOrString($data['club']);
        $model->numeroClub = ValueTransformer::nullOrString($data['nclub']);
        $model->sexe = Sexe::from($data['sexe']);
        $model->numerote = ValueTransformer::exists($data['echelon']);
        $model->numero = ValueTransformer::nullOrInt($data['place'], zeroIncluded: false);
        $model->pointsOfficiels = (float)$data['points'];

        if (str_contains((string)$data['points'], '.')) {
            $model->classementOfficiel = (int)mb_substr(explode('.', (string)$data['points'])[0], 0, -2);
        } else {
            $model->classementOfficiel = (int)mb_substr((string)$data['points'], 0, -2);
        }

        return $model;
    }

    public function licence(): string
    {
        return $this->licence;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function prenom(): string
    {
        return $this->prenom;
    }

    public function club(): ?string
    {
        return $this->club;
    }

    public function numeroClub(): ?string
    {
        return $this->numeroClub;
    }

    public function sexe(): Sexe
    {
        return $this->sexe;
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

    public function classementOfficiel(): int
    {
        return $this->classementOfficiel;
    }
}
