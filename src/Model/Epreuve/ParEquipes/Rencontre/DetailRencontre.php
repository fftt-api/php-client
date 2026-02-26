<?php

declare(strict_types=1);

namespace FFTTApi\Model\Epreuve\ParEquipes\Rencontre;

use FFTTApi\Model\CanSerialize;

final readonly class DetailRencontre implements CanSerialize
{
    private ResultatRencontre $resultat;

    /** @var array<JoueurRencontre> */
    private array $joueurs;

    /** @var array<PartieRencontre> */
    private array $parties;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->resultat = ResultatRencontre::fromArray($data['resultat']);
        $model->joueurs = array_map(
            JoueurRencontre::fromArray(...),
            $data['joueur']
        );
        $model->parties = array_map(
            PartieRencontre::fromArray(...),
            $data['partie']
        );

        return $model;
    }

    public function resultat(): ResultatRencontre
    {
        return $this->resultat;
    }

    /** @return array<JoueurRencontre> */
    public function joueurs(): array
    {
        return $this->joueurs;
    }

    /** @return array<PartieRencontre> */
    public function parties(): array
    {
        return $this->parties;
    }
}
