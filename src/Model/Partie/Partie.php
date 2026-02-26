<?php

declare(strict_types=1);

namespace FFTTApi\Model\Partie;

use Carbon\Carbon;
use FFTTApi\Enum\Sexe;

final readonly class Partie
{
    private Carbon $date;

    private string $nomAdversaire;

    private string $prenomAdversaire;

    private bool $adversaireNumerote;

    private ?int $numeroAdversaire;

    private float $pointsAdversaire;

    private string $epreuve;

    private bool $victoire;

    private bool $forfait;

    private int $partieId;

    private float $coefficient;

    private ?string $licence;

    private ?string $licenceAdversaire;

    private ?int $numeroJournee;

    private ?string $codeChampionnat;

    private ?Sexe $sexeAdversaire;

    private ?float $pointsObtenus;

    private bool $valide;

    public static function fromModels(PartieBaseSPID $baseSPID, ?PartieBaseClassement $baseClassement = null): self
    {
        $model = new self;

        $model->date = $baseSPID->date();
        $model->nomAdversaire = $baseSPID->nom();
        $model->prenomAdversaire = $baseSPID->prenom();
        $model->adversaireNumerote = $baseSPID->numerote();
        $model->numeroAdversaire = $baseSPID->numero();
        $model->pointsAdversaire = $baseSPID->points();
        $model->epreuve = $baseSPID->epreuve();
        $model->victoire = $baseSPID->victoire();
        $model->forfait = $baseSPID->forfait();
        $model->partieId = $baseSPID->partieId();
        $model->coefficient = $baseSPID->coefficient();
        $model->licence = $baseClassement?->licence();
        $model->licenceAdversaire = $baseClassement?->licenceAdversaire();
        $model->numeroJournee = $baseClassement?->numeroJournee();
        $model->codeChampionnat = $baseClassement?->codeChampionnat();
        $model->sexeAdversaire = $baseClassement?->sexeAdversaire();
        $model->pointsObtenus = $baseClassement?->pointsObtenus();
        $model->valide = $baseClassement instanceof PartieBaseClassement;

        return $model;
    }

    public function date(): Carbon
    {
        return $this->date;
    }

    public function nomAdversaire(): string
    {
        return $this->nomAdversaire;
    }

    public function prenomAdversaire(): string
    {
        return $this->prenomAdversaire;
    }

    public function adversaireNumerote(): bool
    {
        return $this->adversaireNumerote;
    }

    public function numeroAdversaire(): ?int
    {
        return $this->numeroAdversaire;
    }

    public function pointsAdversaire(): float
    {
        return $this->pointsAdversaire;
    }

    public function epreuve(): string
    {
        return $this->epreuve;
    }

    public function victoire(): bool
    {
        return $this->victoire;
    }

    public function forfait(): bool
    {
        return $this->forfait;
    }

    public function partieId(): int
    {
        return $this->partieId;
    }

    public function coefficient(): float
    {
        return $this->coefficient;
    }

    public function licence(): ?string
    {
        return $this->licence;
    }

    public function licenceAdversaire(): ?string
    {
        return $this->licenceAdversaire;
    }

    public function numeroJournee(): ?int
    {
        return $this->numeroJournee;
    }

    public function codeChampionnat(): ?string
    {
        return $this->codeChampionnat;
    }

    public function sexeAdversaire(): ?Sexe
    {
        return $this->sexeAdversaire;
    }

    public function pointsObtenus(): ?float
    {
        return $this->pointsObtenus;
    }

    public function valide(): bool
    {
        return $this->valide;
    }
}
