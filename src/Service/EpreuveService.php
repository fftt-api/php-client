<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\EpreuveContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Enum\Charset;
use FFTTApi\Enum\TypeEpreuve;
use FFTTApi\Model\Epreuve\Division;
use FFTTApi\Model\Epreuve\Epreuve;

final readonly class EpreuveService implements EpreuveContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function rechercherEpreuves(int $organizationId, TypeEpreuve $contestType): array
    {
        $response = $this->httpClient->fetch(API::XML_EPREUVE, [
            'organisme' => $organizationId,
            'type' => $contestType->value,
        ], Charset::ISO_8859_1);

        return array_map(Epreuve::fromArray(...), $response['epreuve'] ?? []);
    }

    /** @inheritdoc */
    public function rechercherDivisionsPourEpreuve(int $organizationId, int $contestId, TypeEpreuve $contestType): array
    {
        $response = $this->httpClient->fetch(API::XML_DIVISION, [
            'organisme' => $organizationId,
            'epreuve' => $contestId,
            'type' => $contestType->value,
        ], Charset::ISO_8859_1);

        return array_map(Division::fromArray(...), $response['division'] ?? []);
    }
}
