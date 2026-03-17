<?php

declare(strict_types=1);

namespace FFTTApi\Tests;

use FFTTApi\Core\AbstractHttpClient;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Exception\HttpException;
use FFTTApi\Exception\XMLConversionException;

final class HttpClientMock extends AbstractHttpClient implements HttpClientContract
{
    /**
     * Initialise le client HTTP avec les identifiants fournis par la FFTT.
     *
     * @param string $appId Identifiant unique fourni par la FFTT.
     * @param string $appKey Mot de passe unique fourni par la FFTT.
     * @param string $serial Chaîne de caractères identifiant l'utilisateur de façon permanente, doit respecter le format suivant : [A-Za-z0-9]{15}.
     */
    public function __construct(string $appId, string $appKey, string $serial)
    {
        $this->appId = $appId ?: '1234';
        $this->appKey = $appKey ?: 'abcde';
        $this->serial = $serial ?: '1234';
        $this->time = date('YmdHis');
        $this->tmc = hash_hmac('sha1', $this->time, hash('md5', $this->appKey));
    }

    public function fetch(API $endpoint, array $requestParams): array
    {
        if ($endpoint === API::XML_INITIALISATION) {
            $requestParams['serie'] = $this->serial;
        }

        $mocks = json_decode(file_get_contents(__DIR__ . '/../../snapshots/mocks.json'), associative: true);

        /** @var array{endpoint: string, params: array<string, string|bool|int>, snapshot: string, http_code: int} $mock */
        $mock = null;

        foreach ($mocks as $mockData) {
            if ($mockData['endpoint'] !== mb_substr($endpoint->value, 1)) {
                continue;
            }


            if (count($mockData['params']) === 0) {
                $mock = $mockData;
                break;
            }


            $valid = [];

            foreach ($mockData['params'] as $param => $value) {
                $exists = array_key_exists($param, $requestParams);

                if ($value === true && $exists) {
                    $valid[] = true;
                } elseif ($value === false && !$exists) {
                    $valid[] = true;
                } elseif ($exists && $value === (string)$requestParams[$param]) {
                    $valid[] = true;
                } else {
                    $valid[] = false;
                }
            }

            if (array_all($valid, fn ($v) => $v)) {
                $mock = $mockData;
                break;
            }
        }

        if ($mock === null) {
            return ['error' => 'Aucun snapshot pour cette requête'];
        }

        $mockContent = file_get_contents(__DIR__ . '/../../snapshots/snapshots/' . $mock['snapshot']);

        try {
            $content = $this->sanitizeResponse($mockContent);
            $payload = $this->convertXmlToObject($content);

            if ($mock['http_code'] !== 200) {
                throw new HttpException($payload['erreur']);
            }

            return $payload;
        } catch (XMLConversionException) {
            throw new HttpException('Le format de la réponse reçue n\'est pas valide.');
        }
    }
}
