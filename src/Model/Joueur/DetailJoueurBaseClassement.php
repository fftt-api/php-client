<?php

declare(strict_types=1);

namespace FFTTApi\Model\Joueur;

use FFTTApi\Enum\CategorieLicenceAdministrative;
use FFTTApi\Enum\Nationalite;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class DetailJoueurBaseClassement implements CanSerialize
{
    private string $licence;

    private string $nom;

    private string $prenom;

    private string $club;

    private string $numeroClub;

    private Nationalite $nationalite;

    private int $classementGlobal;

    private ?int $classementGlobalPrecedent;

    private float $pointsMensuels;

    private float $pointsMensuelsPrecedents;

    private bool $numerote;

    private ?int $numero;

    private ?int $classementOfficiel;

    private int $classementNational;

    private CategorieLicenceAdministrative $categorieAdministrative;

    private int $rangRegional;

    private int $rangDepartemental;

    private float $pointsOfficiels;

    private int|string $propositionClassement;

    private int $valeurDebutSaison;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->licence = $data['licence'];
        $model->nom = $data['nom'];
        $model->prenom = $data['prenom'];
        $model->club = $data['club'];
        $model->numeroClub = $data['nclub'];
        $model->nationalite = ValueTransformer::exists($data['natio'])
            ? Nationalite::from($data['nationalite'])
            : Nationalite::FRANCAISE;
        $model->classementGlobal = (int)$data['clglob'];
        $model->classementGlobalPrecedent = ValueTransformer::nullOrInt($data['aclglob'], zeroIncluded: false);
        $model->pointsMensuels = (float)$data['point'];
        $model->pointsMensuelsPrecedents = (float)$data['apoint'];
        $model->numerote = str_starts_with((string)$data['clast'], 'N');

        if ($model->numerote) {
            $model->numero = (int)mb_substr((string)$data['clast'], 1);
            $model->classementOfficiel = null;
        } else {
            $model->numero = null;
            $model->classementOfficiel = (int)$data['clast'];
        }

        $model->classementNational = (int)$data['clnat'];
        $model->categorieAdministrative = CategorieLicenceAdministrative::from($data['categ']);
        $model->rangRegional = (int)$data['rangreg'];
        $model->rangDepartemental = (int)$data['rangdep'];
        $model->pointsOfficiels = (float)$data['valcla'];
        $model->propositionClassement = $data['clpro'];
        $model->valeurDebutSaison = (int)$data['valinit'];

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

    public function nationalite(): Nationalite
    {
        return $this->nationalite;
    }

    public function classementGlobal(): int
    {
        return $this->classementGlobal;
    }

    public function classementGlobalPrecedent(): ?int
    {
        return $this->classementGlobalPrecedent;
    }

    public function pointsMensuels(): float
    {
        return $this->pointsMensuels;
    }

    public function pointsMensuelsPrecedents(): float
    {
        return $this->pointsMensuelsPrecedents;
    }

    public function numerote(): bool
    {
        return $this->numerote;
    }

    public function numero(): ?int
    {
        return $this->numero;
    }

    public function classementOfficiel(): ?int
    {
        return $this->classementOfficiel;
    }

    public function classementNational(): int
    {
        return $this->classementNational;
    }

    public function categorieSportive(): CategorieLicenceAdministrative
    {
        return $this->categorieAdministrative;
    }

    public function rangRegional(): int
    {
        return $this->rangRegional;
    }

    public function rangDepartemental(): int
    {
        return $this->rangDepartemental;
    }

    public function pointsOfficiels(): float
    {
        return $this->pointsOfficiels;
    }

    public function propositionClassement(): int|string
    {
        return $this->propositionClassement;
    }

    public function valeurDebutSaison(): int
    {
        return $this->valeurDebutSaison;
    }
}
