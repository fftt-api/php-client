<?php

declare(strict_types=1);

namespace FFTTApi\Core;

use FFTTApi\Enum\Charset;
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

    protected function sanitizeResponse(string $content, Charset $charset): string
    {
        if ($charset === Charset::UTF_8) {
            $pattern = sprintf('/encoding="%s"/i', Charset::ISO_8859_1->value);
            $replacement = sprintf('encoding="%s"', Charset::UTF_8->value);
            return preg_replace($pattern, $replacement, $content);
        }

        return $content;
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

        /**
         * Extraction des 200 premiers bytes de la chaîne pour
         * détection automatique de l'encodage utilisé.
         */
        $header = mb_substr($content, 0, min(200, mb_strlen($content)));

        /**
         * Si l'encodage présenté est en ISO-8859-1, on essaie
         * de le convertir en UTF-8.
         */
        if (mb_stripos($header, 'ISO-8859-1') !== false) {
            // Détection de l'encodage réel et conversion en UTF-8
            $detectedEncoding = mb_detect_encoding($content, encodings: ['UTF-8', 'ISO-8859-1'], strict: true);

            if ($detectedEncoding && $detectedEncoding !== 'UTF-8') {
                $content = mb_convert_encoding($content, 'UTF-8', $detectedEncoding);
            }

            // Mise à jour de la déclaration XML
            $content = str_ireplace('encoding="ISO-8859-1"', 'encoding="UTF-8"', $content);
            $content = str_ireplace("encoding='ISO-8859-1'", "encoding='UTF-8'", $content);
        }

        $converted = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($converted === false) {
            throw XMLConversionException::make();
        }

        return json_decode(json_encode($converted), associative: true);
    }
}
