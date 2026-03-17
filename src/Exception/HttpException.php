<?php

declare(strict_types=1);

namespace FFTTApi\Exception;

use Exception;
use RuntimeException;

final class HttpException extends RuntimeException
{
    public static function make(string $error): self
    {
        return new self(
            message: "Une erreur inattendue est survenue pendant l'appel aux serveurs de la FFTT.",
            previous: new Exception($error),
        );
    }
}
