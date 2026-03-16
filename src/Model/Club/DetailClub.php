<?php

declare(strict_types=1);

namespace FFTTApi\Model\Club;

use Carbon\Carbon;
use FFTTApi\Util\ValueTransformer;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\DateTimeUtils;

final readonly class DetailClub implements CanSerialize
{
    private string $id;

    private string $numero;

    private string $nom;

    private ?string $siteInternet;

    private Salle $salle;

    private Correspondant $correspondant;

    private ?Carbon $dateValidation;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->id = $data['idclub'];
        $model->numero = $data['numero'];
        $model->nom = $data['nom'];
        $model->siteInternet = ValueTransformer::nullOrString($data['web']);
        $model->dateValidation = ValueTransformer::nullOrDate($data['validation'], format: 'd/m/Y');

        $model->salle = new Salle(
            nom: $data['nomsalle'],
            ligneAdresse1: $data['adressesalle1'],
            codePostal: $data['codepsalle'],
            ville: $data['villesalle'],
            ligneAdresse2: ValueTransformer::nullOrString($data['adressesalle2']),
            ligneAdresse3: ValueTransformer::nullOrString($data['adressesalle3']),
            latitude: ValueTransformer::nullOrFloat($data['latitude']),
            longitude: ValueTransformer::nullOrFloat($data['longitude']),
        );

        $model->correspondant = new Correspondant(
            nom: $data['nomcor'],
            prenom: $data['prenomcor'],
            email: ValueTransformer::nullOrString($data['mailcor']),
            telephone: ValueTransformer::nullOrString($data['telcor']),
        );

        return $model;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function numero(): string
    {
        return $this->numero;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function salle(): Salle
    {
        return $this->salle;
    }

    public function correspondant(): Correspondant
    {
        return $this->correspondant;
    }

    public function siteInternet(): ?string
    {
        return $this->siteInternet;
    }

    public function dateValidation(): ?Carbon
    {
        return $this->dateValidation;
    }
}
