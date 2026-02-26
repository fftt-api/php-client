<?php

declare(strict_types=1);

namespace FFTTApi\Exception;

use RuntimeException;

final class AuthentificationException extends RuntimeException
{
    public static function make(string $error): self
    {
        return new self('Erreur d\'authentification : ' . $error);
    }
}
