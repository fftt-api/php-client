<?php

declare(strict_types=1);

namespace FFTTApi\Core;

use FFTTApi\Exception\XMLConversionException;

abstract class AbstractHttpClient
{
    /** @var string Identifiant unique fourni par la FFTT. */
    protected string $appId;

    /** @var string Mot de passe unique fourni par la FFTT. */
    protected string $appKey;

    /**
     * @var string Chaîne de caractères identifiant l'utilisateur de façon permanente.
     * Elle doit respecter le format suivant : [A-Za-z0-9]{15}.
     */
    protected string $serial;

    protected string $time;

    protected string $tmc;

    /** @var string URL de base sur laquelle les endpoints se greffent. */
    protected string $baseUrl = 'https://apiv2.fftt.com/mobile/pxml';

    protected function sanitizeResponse(string $content, ?string $contentType = null): string
    {
        $content = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $content);

        if ($contentType !== 'text/html; charset=UTF-8') {
            $content = mb_convert_encoding($content, 'ISO-8859-1', 'UTF-8');
        }

        return html_entity_decode((string)$content);
    }

    /**
     * Transforme une réponse XML en tableau associatif.
     *
     * @throws XMLConversionException
     */
    protected function convertXmlToObject(string $content): array
    {
        if (empty($content)) {
            return [];
        }

        if (!str_starts_with($content, '<?xml')) {
            throw XMLConversionException::make();
        }

        $converted = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($converted === false) {
            throw XMLConversionException::make();
        }

        return json_decode(json_encode($converted), associative: true);
    }
}
