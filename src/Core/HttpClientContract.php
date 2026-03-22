<?php

declare(strict_types=1);

namespace FFTTApi\Core;

use FFTTApi\Enum\API;
use FFTTApi\Enum\Charset;

interface HttpClientContract
{
    /**
     * Appelle un endpoint et le convertit en tableau associatif.
     */
    public function fetch(API $endpoint, array $requestParams, Charset $charset = Charset::ISO_8859_1): array;
}
