<?php

declare(strict_types=1);

namespace FFTTApi\Core;

use FFTTApi\Enum\API;
use FFTTApi\Enum\Charset;
use FFTTApi\Exception\HttpException;
use FFTTApi\Exception\XMLConversionException;

/**
 * Client HTTP pour communiquer avec l'API de la FFTT.
 */
final class HttpClient extends AbstractHttpClient implements HttpClientContract
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
        $this->appId = $appId;
        $this->appKey = $appKey;
        $this->serial = $serial;
        $this->time = date('YmdHis');
        $this->tmc = hash_hmac('sha1', $this->time, hash('md5', $this->appKey));
    }

    /**
     * Appelle un endpoint et le convertit en tableau associatif.
     */
    public function fetch(API $endpoint, array $requestParams, Charset $charset = Charset::ISO_8859_1): array
    {
        ['response' => $rawResponse, 'httpCode' => $httpCode] = self::executeCall($endpoint, $requestParams);

        try {
            $sanitizedResponse = self::sanitizeResponse($rawResponse, $charset);
            $payload = self::convertXmlToObject($sanitizedResponse);

            if ($httpCode !== 200) {
                throw new HttpException($payload['erreur']);
            }

            return $payload;
        } catch (XMLConversionException) {
            throw new HttpException('Le format de la réponse reçue n\'est pas valide.');
        }
    }

    /**
     * Appelle un endpoint de la Fédération.
     *
     *
     * @return array{response: string, contentType: string, httpCode: int}
     *
     * @throws HttpException
     */
    private function executeCall(API $endpoint, array $requestParams): array
    {
        $ch = curl_init();

        /**
         * Crée les paramètres communs obligatoires.
         */
        $baseParams = [
            'serie' => $this->serial,
            'id' => $this->appId,
            'tm' => $this->time,
            'tmc' => $this->tmc,
        ];

        /**
         * @var array<string, string> $params
         * Merge l'ensemble des paramètres pour la requête.
         */
        $params = array_merge($baseParams, $requestParams);

        /**
         * Transforme les paramètres en paramètres de requête.
         */
        $queryParams = '';
        foreach ($params as $paramKey => $paramValue) {
            $queryParams .= sprintf('&%s=', $paramKey) . urlencode($paramValue);
        }

        /**
         * Supprime le premier `&`.
         */
        $queryParamsEncoded = mb_substr($queryParams, 1);

        /**
         * Exécute la requête.
         */
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl . $endpoint->value . '?' . $queryParamsEncoded,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = (string)curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_error($ch) !== '' && curl_error($ch) !== '0') {
            throw HttpException::make(curl_error($ch));
        }

        return [
            'response' => $response,
            'httpCode' => $httpCode,
        ];
    }
}
