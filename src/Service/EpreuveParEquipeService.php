<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\EpreuveParEquipeContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Model\Epreuve\ParEquipes\Poule\EquipePoule;
use FFTTApi\Model\Epreuve\ParEquipes\Poule\Poule;
use FFTTApi\Model\Epreuve\ParEquipes\Rencontre\DetailRencontre;
use FFTTApi\Model\Epreuve\ParEquipes\Rencontre\Rencontre;

final readonly class EpreuveParEquipeService implements EpreuveParEquipeContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function poulesPourDivision(int $divisionId): array
    {
        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, [
            'action' => 'poule',
            'auto' => 1,
            'D1' => $divisionId,
        ]);

        return array_map(Poule::fromArray(...), $response['poule'] ?? []);
    }

    /** @inheritdoc */
    public function rencontresPourPoule(int $divisionId, ?int $pouleId = null): array
    {
        $params = [
            'action' => '',
            'auto' => 1,
            'D1' => $divisionId,
        ];

        if ($pouleId !== null) {
            $params['cx_poule'] = $pouleId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, $params);

        return array_map(Rencontre::fromArray(...), $response['tour'] ?? []);
    }

    /** @inheritdoc */
    public function ordrePoule(int $divisionId, ?int $pouleId = null): array
    {
        $params = [
            'action' => 'initial',
            'auto' => 1,
            'D1' => $divisionId,
        ];

        if ($pouleId !== null) {
            $params['cx_poule'] = $pouleId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, $params);

        $results = [];

        foreach ($response['classement'] ?? [] as $index => $item) {
            $item['pos'] = $index + 1;
            $results[] = EquipePoule::fromArray($item);
        }

        return $results;
    }

    /** @inheritdoc */
    public function classementPoule(int $divisionId, ?int $pouleId = null): array
    {
        $params = [
            'action' => 'classement',
            'auto' => 1,
            'D1' => $divisionId,
        ];

        if ($pouleId !== null) {
            $params['cx_poule'] = $pouleId;
        }

        $response = $this->httpClient->fetch(API::XML_RESULT_EQU, $params);

        return array_map(EquipePoule::fromArray(...), $response['classement'] ?? []);
    }

    /** @inheritdoc */
    public function detailRencontre(int $rencontreId, ?array $extraParams = null): ?DetailRencontre
    {
        $params = [
            'renc_id' => $rencontreId,
        ];

        if ($extraParams !== null) {
            $params = array_merge($params, $extraParams);
        }

        $response = $this->httpClient->fetch(API::XML_CHP_RENC, $params);

        if (empty($response)) {
            return null;
        }

        return DetailRencontre::fromArray($response);
    }
}
