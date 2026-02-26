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
            message: "Unexpected error happened while fetching FFTT servers.",
            previous: new Exception($error),
        );
    }
}
