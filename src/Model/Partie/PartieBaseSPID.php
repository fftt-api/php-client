<?php

declare(strict_types=1);

namespace FFTTApi\Model\Partie;

use Carbon\Carbon;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\DateTimeUtils;
use FFTTApi\Util\JoueurUtils;

final readonly class PartieBaseSPID implements CanSerialize
{
    private Carbon $date;

    private string $nom;

    private string $prenom;

    private bool $numerote;

    private ?int $numero;

    private float $points;

    private string $epreuve;

    private bool $victoire;

    private bool $forfait;

    private int $partieId;

    private float $coefficient;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->date = DateTimeUtils::date($data['date'], format: 'd/m/Y');
        [$model->nom, $model->prenom] = JoueurUtils::separerNomPrenom($data['nom']);
        $model->numerote = str_starts_with((string)$data['classement'], 'N');
        $model->epreuve = $data['epreuve'];
        $model->victoire = $data['victoire'] === 'V';
        $model->forfait = (bool)$data['forfait'];
        $model->partieId = (int)$data['idpartie'];
        $model->coefficient = (float)$data['coefchamp'];

        $classement = JoueurUtils::parseClassementJoueur($data['classement']);
        $model->numero = $classement['numero'];
        $model->points = $classement['points'];

        return $model;
    }

    public function date(): Carbon
    {
        return $this->date;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function prenom(): string
    {
        return $this->prenom;
    }

    public function points(): float
    {
        return $this->points;
    }

    public function numerote(): bool
    {
        return $this->numerote;
    }

    public function numero(): ?int
    {
        return $this->numero;
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
}
