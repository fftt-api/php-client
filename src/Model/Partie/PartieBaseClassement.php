<?php

declare(strict_types=1);

namespace FFTTApi\Model\Partie;

use Carbon\Carbon;
use FFTTApi\Enum\Sexe;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\DateTimeUtils;
use FFTTApi\Util\JoueurUtils;
use FFTTApi\Util\ValueTransformer;

final readonly class PartieBaseClassement implements CanSerialize
{
    private string $licence;

    private string $licenceAdversaire;

    private bool $victoire;

    private ?int $numeroJournee;

    private string $codeChampionnat;

    private Carbon $date;

    private Sexe $sexeAdversaire;

    private string $nomAdversaire;

    private string $prenomAdversaire;

    private bool $adversaireNumerote;

    private ?int $numeroAdversaire;

    private float $pointsObtenus;

    private float $coefficient;

    private ?int $classementAdversaire;

    private int $partieId;

    private bool $valide;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->valide = true;
        $model->licence = $data['licence'];
        $model->licenceAdversaire = $data['advlic'];
        $model->victoire = $data['vd'] === 'V';
        $model->numeroJournee = ValueTransformer::nullOrInt($data['numjourn']);
        $model->codeChampionnat = $data['codechamp'];
        $model->date = DateTimeUtils::date($data['date'], format: 'd/m/Y');
        $model->sexeAdversaire = Sexe::from($data['advsexe']);
        [$model->nomAdversaire, $model->prenomAdversaire] = JoueurUtils::separerNomPrenom($data['advnompre']);
        $model->pointsObtenus = (float)$data['pointres'];
        $model->coefficient = (float)$data['coefchamp'];
        $model->partieId = (int)$data['idpartie'];

        if (str_starts_with($data['advclaof'], 'N')) {
            $model->adversaireNumerote = true;
            $model->numeroAdversaire = (int)mb_substr($data['advclaof'], 1);
            $model->classementAdversaire = null;
        } else {
            $model->adversaireNumerote = false;
            $model->numeroAdversaire = null;
            $model->classementAdversaire = (int)$data['advclaof'];
        }

        return $model;
    }

    public function partieId(): int
    {
        return $this->partieId;
    }

    public function licence(): string
    {
        return $this->licence;
    }

    public function licenceAdversaire(): string
    {
        return $this->licenceAdversaire;
    }

    public function numeroJournee(): ?int
    {
        return $this->numeroJournee;
    }

    public function codeChampionnat(): string
    {
        return $this->codeChampionnat;
    }

    public function sexeAdversaire(): Sexe
    {
        return $this->sexeAdversaire;
    }

    public function pointsObtenus(): float
    {
        return $this->pointsObtenus;
    }

    public function coefficient(): float
    {
        return $this->coefficient;
    }

    public function valide(): bool
    {
        return $this->valide;
    }

    public function victoire(): bool
    {
        return $this->victoire;
    }

    public function adversaireNumerote(): bool
    {
        return $this->adversaireNumerote;
    }

    public function numeroAdversaire(): ?int
    {
        return $this->numeroAdversaire;
    }

    public function classementAdversaire(): ?int
    {
        return $this->classementAdversaire;
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
}
