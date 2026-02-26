<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\EpreuveIndividuelleContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Model\Epreuve\Individuelle\Classement;
use FFTTApi\Model\Epreuve\Individuelle\Groupe;
use FFTTApi\Model\Epreuve\Individuelle\Partie;

final readonly class EpreuveIndividuelleService implements EpreuveIndividuelleContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function rechercherGroupes(int $epreuveId, int $divisionId): array
    {
        $response = $this->httpClient->fetch(API::XML_RESULT_INDIV, [
            'action' => 'poule',
            'epr' => $epreuveId,
            'res_division' => $divisionId,
        ]);

        return array_map(Groupe::fromArray(...), $response['tour'] ?? []);
    }

    /** @inheritdoc */
    public function recupererParties(int $epreuveId, int $divisionId, ?int $groupeId = null): array
    {
        $params = [
            'action' => 'partie',
            'epr' => $epreuveId,
            'res_division' => $divisionId,
        ];

        if ($groupeId !== null) {
            $params['cx_tableau'] = $groupeId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_INDIV, $params);

        return array_map(Partie::fromArray(...), $response['partie'] ?? []);
    }

    /** @inheritdoc */
    public function recupererClassement(int $epreuveId, int $divisionId, ?int $groupeId = null): array
    {
        $params = [
            'action' => 'classement',
            'epr' => $epreuveId,
            'res_division' => $divisionId,
        ];

        if ($groupeId !== null) {
            $params['cx_tableau'] = $groupeId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_INDIV, $params);

        return array_map(Classement::fromArray(...), $response['classement'] ?? []);
    }

    /** @inheritdoc */
    public function recupererClassementCriterium(int $divisionId): array
    {
        $response = $this->httpClient->fetch(API::XML_RES_CLA, ['res_division' => $divisionId]);

        return array_map(Classement::fromArray(...), $response['classement'] ?? []);
    }
}
