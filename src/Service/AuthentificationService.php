<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\AuthentificationContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Model\Divers\Initialisation;

final readonly class AuthentificationService implements AuthentificationContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function authentifier(): bool
    {
        $response = $this->httpClient->fetch(API::XML_INITIALISATION, []);

        return Initialisation::fromArray($response)->appli();
    }
}
