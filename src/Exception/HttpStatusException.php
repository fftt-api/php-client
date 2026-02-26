<?php

declare(strict_types=1);

namespace FFTTApi\Exception;

use RuntimeException;

final class HttpStatusException extends RuntimeException
{
    public static function make(int $code): self
    {
        return new self(sprintf('Received HTTP code %d, expected 200', $code));
    }
}
