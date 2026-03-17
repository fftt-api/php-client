<?php

declare(strict_types=1);

namespace FFTTApi\Tests;

use FFTTApi\Core\AbstractHttpClient;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;

final class HttpClientMock extends AbstractHttpClient implements HttpClientContract
{
    public function fetch(API $endpoint, array $requestParams): array
    {
        $mocks = json_decode(file_get_contents(__DIR__ . '/../../snapshots/mocks.json'), associative: true);
        $mock = null;

        foreach ($mocks as $mockData) {
            if ($mockData['endpoint'] !== $endpoint) {
                continue;
            }

            if (count($mockData['params']) === 0) {
                $mock = $mockData['snapshot'];
                break;
            }

            $valid = false;
            foreach ($mockData['params'] as $param => $value) {
                if (
                    $value === true && isset($requestParams[$param])
                    || $value === false && !isset($requestParams[$param])
                    || $value === (string)$requestParams[$param]
                ) {
                    $valid = true;
                }
            }

            if ($valid) {
                $mock = $mockData['snapshot'];
                break;
            }
        }

        if ($mock === null) {
            return ['error' => 'Aucun snapshot pour cette requête'];
        }

        $mockContent = file_get_contents(__DIR__ . '/../../snapshots/snapshots/' . $mock);

        $content = $this->sanitizeResponse($mockContent);

        return $this->convertXmlToObject($content);
    }
}
