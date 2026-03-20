<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Poule;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class EquipePoule implements CanSerialize
{
    private int $poule;

    private ?int $classement;

    private string $equipe;

    private int $rencontresJouees;

    private int $pointsRencontre;

    private string $numeroClub;

    private int $pointsPartieGagnes;

    private int $pointsPartiePerdus;

    private int $idEquipe;

    private int $idClub;

    private int $victoires;

    private int $defaites;

    private int $nuls;

    private int $totalPenalitesOuForfaits;

    private ?int $positionDepart;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->poule = (int)$data['poule'];
        $model->classement = array_key_exists('classement', $data) ? $data['classement'] : null;
        $model->equipe = $data['equipe'];
        $model->rencontresJouees = (int)$data['joue'];
        $model->pointsRencontre = (int)$data['pts'];
        $model->numeroClub = $data['numero'];
        $model->pointsPartieGagnes = (int)$data['pg'];
        $model->pointsPartiePerdus = (int)$data['pp'];
        $model->idEquipe = (int)$data['idequipe'];
        $model->idClub = (int)$data['idclub'];
        $model->victoires = (int)$data['vic'];
        $model->defaites = (int)$data['def'];
        $model->nuls = (int)$data['nul'];
        $model->totalPenalitesOuForfaits = (int)$data['pf'];
        $model->positionDepart = array_key_exists('pos', $data) ? ValueTransformer::nullOrInt($data['pos']) : null;

        return $model;
    }

    public function poule(): int
    {
        return $this->poule;
    }

    public function classement(): int
    {
        return $this->classement;
    }

    public function equipe(): string
    {
        return $this->equipe;
    }

    public function rencontresJouees(): int
    {
        return $this->rencontresJouees;
    }

    public function pointsRencontre(): int
    {
        return $this->pointsRencontre;
    }

    public function numeroClub(): string
    {
        return $this->numeroClub;
    }

    public function pointsPartieGagnes(): int
    {
        return $this->pointsPartieGagnes;
    }

    public function pointsPartiePerdus(): int
    {
        return $this->pointsPartiePerdus;
    }

    public function idEquipe(): int
    {
        return $this->idEquipe;
    }

    public function idClub(): int
    {
        return $this->idClub;
    }

    public function victoires(): int
    {
        return $this->victoires;
    }

    public function defaites(): int
    {
        return $this->defaites;
    }

    public function nuls(): int
    {
        return $this->nuls;
    }

    public function totalPenalitesOuForfaits(): int
    {
        return $this->totalPenalitesOuForfaits;
    }

    public function positionDepart(): ?int
    {
        return $this->positionDepart;
    }
}
