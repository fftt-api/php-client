<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\Individuelle;

use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\JoueurUtils;
use FFTTApi\Util\ValueTransformer;

final readonly class Partie implements CanSerialize
{
    private string $libelle;

    private string $nomGagnant;

    private string $prenomGagnant;

    private string $nomPerdant;

    private string $prenomPerdant;

    private bool $gagneParForfait;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->libelle = $data['libelle'];
        [$model->nomGagnant, $model->prenomGagnant] = JoueurUtils::separerNomPrenom($data['vain']);
        [$model->nomPerdant, $model->prenomPerdant] = JoueurUtils::separerNomPrenom($data['perd']);
        $model->gagneParForfait = ValueTransformer::exists($data['forfait']);

        return $model;
    }

    public function libelle(): string
    {
        return $this->libelle;
    }

    public function nomGagnant(): string
    {
        return $this->nomGagnant;
    }

    public function prenomGagnant(): string
    {
        return $this->prenomGagnant;
    }

    public function nomPerdant(): string
    {
        return $this->nomPerdant;
    }

    public function prenomPerdant(): string
    {
        return $this->prenomPerdant;
    }

    public function gagneParForfait(): bool
    {
        return $this->gagneParForfait;
    }
}
