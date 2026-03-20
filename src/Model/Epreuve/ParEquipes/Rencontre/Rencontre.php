<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Rencontre;

use Carbon\Carbon;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\DateTimeUtils;
use FFTTApi\Util\ValueTransformer;

final readonly class Rencontre implements CanSerialize
{
    private int $id;

    private string $libelle;

    private ?string $equipeA;

    private ?string $equipeB;

    private ?int $scoreEquipeA;

    private ?int $scoreEquipeB;

    private string $lien;

    private Carbon $datePrevue;

    private ?Carbon $dateReelle;

    private ?string $numeroClubA;

    private ?string $numeroClubB;

    /**
     * @var array{
     *     is_retour: bool,
     *     phase: int,
     *     res_1: int,
     *     res_2: int,
     *     equip_1: string,
     *     equip_2: string,
     *     equip_id1: int,
     *     equip_id2: int
     * } $parametresAccesAuDetail
     */
    private array $parametresAccesAuDetail;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->libelle = $data['libelle'];
        $model->equipeA = ValueTransformer::nullOrString($data['equa']);
        $model->equipeB = ValueTransformer::nullOrString($data['equb']);
        $model->scoreEquipeA = ValueTransformer::nullOrInt($data['scorea']);
        $model->scoreEquipeB = ValueTransformer::nullOrInt($data['scoreb']);
        $model->lien = $data['lien'];
        $model->datePrevue = DateTimeUtils::date($data['dateprevue'], format: 'd/m/Y');
        $model->dateReelle = ValueTransformer::nullOrDate($data['datereelle']);

        parse_str((string)$data['lien'], $linkParts);

        $model->id = (int)$linkParts['renc_id'];
        $model->parametresAccesAuDetail = [
            'is_retour' => (bool)$linkParts['is_retour'],
            'phase' => (int)$linkParts['phase'],
            'res_1' => (int)$linkParts['res_1'],
            'res_2' => (int)$linkParts['res_2'],
            'equip_1' => $linkParts['equip_1'],
            'equip_2' => $linkParts['equip_2'],
            'equip_id1' => (int)$linkParts['equip_id1'],
            'equip_id2' => (int)$linkParts['equip_id2'],
        ];

        $model->numeroClubA = ValueTransformer::nullOrString($linkParts['clubnum_1']);
        $model->numeroClubB = ValueTransformer::nullOrString($linkParts['clubnum_2']);

        return $model;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }

    public function equipeA(): ?string
    {
        return $this->equipeA;
    }

    public function equipeB(): ?string
    {
        return $this->equipeB;
    }

    public function scoreEquipeA(): ?int
    {
        return $this->scoreEquipeA;
    }

    public function scoreEquipeB(): ?int
    {
        return $this->scoreEquipeB;
    }

    public function lien(): string
    {
        return $this->lien;
    }

    /**
     * @return array{
     *     is_retour: bool,
     *     phase: int,
     *     res_1: int,
     *     res_2: int,
     *     equip_1: string,
     *     equip_2: string,
     *     equip_id1: int,
     *     equip_id2: int
     * }
     */
    public function parametresAccesAuDetail(): array
    {
        return $this->parametresAccesAuDetail;
    }

    public function datePrevue(): Carbon
    {
        return $this->datePrevue;
    }

    public function dateReelle(): ?Carbon
    {
        return $this->dateReelle;
    }

    public function numeroClubA(): ?string
    {
        return $this->numeroClubA;
    }

    public function numeroClubB(): ?string
    {
        return $this->numeroClubB;
    }

    public function idPoule(): int
    {
        return $this->idPoule;
    }

    public function isLive(): bool
    {
        return $this->isLive;
    }
}
