<?php

declare(strict_types=1);

namespace FFTTApi\Model\Joueur;

use FFTTApi\Model\CanSerialize;

final readonly class JoueurBaseClassement implements CanSerialize
{
    private string $licence;

    private string $nom;

    private string $prenom;

    private string $club;

    private string $numeroClub;

    private ?int $classement;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->licence = $data['licence'];
        $model->nom = $data['nom'];
        $model->prenom = $data['prenom'];
        $model->club = $data['club'];
        $model->numeroClub = $data['nclub'];

        if (!str_starts_with((string)$data['clast'], 'N')) {
            $model->classement = (int)$data['clast'];
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

    public function club(): string
    {
        return $this->club;
    }

    public function numeroClub(): string
    {
        return $this->numeroClub;
    }

    public function classement(): ?int
    {
        return $this->classement;
    }
}
