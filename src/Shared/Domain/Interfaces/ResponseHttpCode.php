<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

/**
 * Interface ResponseHttpCode
 * @package App\Shared\Domain\Interfaces
 */
interface ResponseHttpCode
{
    public const HTTP_OK = 200;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;
}
