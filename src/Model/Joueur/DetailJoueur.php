<?php

declare(strict_types=1);

namespace FFTTApi\Model\Joueur;

use Carbon\Carbon;
use FFTTApi\Enum\CategorieLicenceAdministrative;
use FFTTApi\Enum\CertificationMedicale;
use FFTTApi\Enum\Diplome;
use FFTTApi\Enum\Nationalite;
use FFTTApi\Enum\Sexe;
use FFTTApi\Enum\TypeLicence;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\ValueTransformer;

final readonly class DetailJoueur implements CanSerialize
{
    private int $licenceId;

    private string $licence;

    private string $nom;

    private string $prenom;

    private string $club;

    private string $numeroClub;

    private Sexe $sexe;

    private ?TypeLicence $typeLicence;

    private CertificationMedicale $certificationMedicale;

    private ?Carbon $dateValidation;

    private bool $numerote;

    private ?int $numero;

    private float $pointsOfficiels;

    private CategorieLicenceAdministrative $categorieAdministrative;

    private ?float $pointsMensuels;

    private ?float $pointsMensuelsPrecedents;

    private ?float $valeurInitiale;

    private ?Carbon $dateMutation;

    private Nationalite $nationalite;

    private ?Diplome $plusHautGradeArbitre;

    private ?Diplome $plusHautGradeJugeArbitre;

    private ?Diplome $plusHautGradeTechnique;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->licenceId = (int)$data['idlicence'];
        $model->licence = $data['licence'];
        $model->nom = $data['nom'];
        $model->prenom = $data['prenom'];
        $model->club = $data['nomclub'];
        $model->numeroClub = $data['numclub'];
        $model->sexe = Sexe::from($data['sexe']);
        $model->typeLicence = ValueTransformer::nullOrEnum($data['type'], TypeLicence::class);
        $model->certificationMedicale = CertificationMedicale::from($data['certif']);
        $model->dateValidation = ValueTransformer::nullOrDate($data['validation']);
        $model->numerote = ValueTransformer::exists($data['echelon']);
        $model->numero = ValueTransformer::nullOrInt($data['place'], zeroIncluded: false);
        $model->pointsOfficiels = (float)$data['point'];
        $model->categorieAdministrative = CategorieLicenceAdministrative::from($data['cat']);
        $model->pointsMensuels = ValueTransformer::nullOrFloat($data['pointm']);
        $model->pointsMensuelsPrecedents = ValueTransformer::nullOrFloat($data['apointm']);
        $model->valeurInitiale = ValueTransformer::nullOrFloat($data['initm']);
        $model->dateMutation = ValueTransformer::nullOrDate($data['mutation']);
        $model->nationalite = Nationalite::from($data['natio']);
        $model->plusHautGradeArbitre = ValueTransformer::nullOrEnum($data['arb'], Diplome::class);
        $model->plusHautGradeJugeArbitre = ValueTransformer::nullOrEnum($data['ja'], Diplome::class);
        $model->plusHautGradeTechnique = ValueTransformer::nullOrEnum($data['tech'], Diplome::class);

        return $model;
    }

    public function licenceId(): int
    {
        return $this->licenceId;
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

    public function sexe(): Sexe
    {
        return $this->sexe;
    }

    public function typeLicence(): ?TypeLicence
    {
        return $this->typeLicence;
    }

    public function certificationMedicale(): CertificationMedicale
    {
        return $this->certificationMedicale;
    }

    public function dateValidation(): ?Carbon
    {
        return $this->dateValidation;
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

    public function categorieSportive(): CategorieLicenceAdministrative
    {
        return $this->categorieAdministrative;
    }

    public function pointsMensuels(): ?float
    {
        return $this->pointsMensuels;
    }

    public function pointsMensuelsPrecedents(): ?float
    {
        return $this->pointsMensuelsPrecedents;
    }

    public function valeurInitiale(): ?float
    {
        return $this->valeurInitiale;
    }

    public function dateMutation(): ?Carbon
    {
        return $this->dateMutation;
    }

    public function nationalite(): Nationalite
    {
        return $this->nationalite;
    }

    public function plusHautGradeArbitre(): ?Diplome
    {
        return $this->plusHautGradeArbitre;
    }

    public function plusHautGradeJugeArbitre(): ?Diplome
    {
        return $this->plusHautGradeJugeArbitre;
    }

    public function plusHautGradeTechnique(): ?Diplome
    {
        return $this->plusHautGradeTechnique;
    }
}
