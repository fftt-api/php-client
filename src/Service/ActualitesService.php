<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\ActualitesContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Model\Divers\Actualite;

final readonly class ActualitesService implements ActualitesContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function fluxActualitesFederation(): array
    {
        $response = $this->httpClient->fetch(API::XML_NEW_ACTU, []);

        return array_map(Actualite::fromArray(...), $response['news']);
    }
}
