<?php

declare(strict_types=1);

namespace FFTTApi\Model\Club;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Model\Epreuve\Division;

final readonly class Equipe implements CanSerialize
{
    private int $idEpreuve;

    private string $libelleEpreuve;

    private int $idEquipe;

    private string $libelleEquipe;

    private string $libelleDivision;

    private string $lienDivision;

    private int $idPoule;

    private int $idDivision;

    private int $idOrganisme;

    private Division $division;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->idEpreuve = (int)$data['idepr'];
        $model->libelleEpreuve = $data['libepr'];
        $model->idEquipe = (int)$data['idequipe'];
        $model->libelleEquipe = $data['libequipe'];
        $model->libelleDivision = $data['libdivision'];
        $model->lienDivision = $data['liendivision'];

        parse_str((string)$data['liendivision'], $linkParts);

        $model->idPoule = (int)$linkParts['cx_poule'];
        $model->idDivision = (int)$linkParts['D1'];
        $model->idOrganisme = (int)$linkParts['organisme_pere'];

        $model->division = Division::fromArray([
            'id' => $model->idDivision,
            'libelle' => $model->libelleDivision,
        ]);

        return $model;
    }

    public function idEquipe(): int
    {
        return $this->idEquipe;
    }

    public function idDivision(): int
    {
        return $this->idDivision;
    }

    public function idOrganisme(): int
    {
        return $this->idOrganisme;
    }

    public function idPoule(): int
    {
        return $this->idPoule;
    }

    public function idEpreuve(): int
    {
        return $this->idEpreuve;
    }

    public function libelleEpreuve(): string
    {
        return $this->libelleEpreuve;
    }

    public function libelleEquipe(): string
    {
        return $this->libelleEquipe;
    }

    public function lienDivision(): string
    {
        return $this->lienDivision;
    }

    public function libelleDivision(): string
    {
        return $this->libelleDivision;
    }

    public function division(): Division
    {
        return $this->division;
    }
}
