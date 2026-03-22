<?php

declare(strict_types=1);

namespace FFTTApi\Tests;

use FFTTApi\Core\AbstractHttpClient;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Enum\Charset;
use FFTTApi\Exception\HttpException;
use FFTTApi\Exception\XMLConversionException;
use LibXMLError;

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

    public function fetch(API $endpoint, array $requestParams, Charset $charset = Charset::UTF_8): array
    {
        libxml_use_internal_errors(true);

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
            // Convert XML first, then sanitize is not needed as convertXmlToObject handles it
            $payload = $this->convertXmlToObject($mockContent);

            if ($mock['http_code'] !== 200) {
                throw new HttpException($payload['erreur']);
            }

            return $payload;
        } catch (XMLConversionException) {
            throw new HttpException('Le format de la réponse reçue n\'est pas valide.');
        }
    }

    /**
     * Transforme une réponse XML en tableau associatif.
     *
     * @throws XMLConversionException
     */
    protected function convertXmlToObject(string $content): array
    {
        try {
            return parent::convertXmlToObject($content);
        } catch (XMLConversionException $e) {
            // Display XML errors for debugging in tests
            $errors = libxml_get_errors();

            foreach ($errors as $error) {
                echo $this->displayXmlError($error, $content);
            }

            libxml_clear_errors();

            throw $e;
        }
    }

    private function displayXmlError(LibXMLError $error, string $xml): string
    {
        $return = $xml[$error->line - 1] . "\n";
        $return .= str_repeat('-', $error->column) . "^\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "Warning $error->code: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "Error $error->code: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "Fatal Error $error->code: ";
                break;
        }

        $return .= mb_trim($error->message) .
            "\n  Line: $error->line" .
            "\n  Column: $error->column";

        if ($error->file) {
            $return .= "\n  File: $error->file";
        }

        return "$return\n\n--------------------------------------------\n\n";
    }
}
