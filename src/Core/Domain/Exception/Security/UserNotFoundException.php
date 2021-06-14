<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception\Security;

use App\Shared\Domain\Interfaces\ResponseHttpCode;
use InvalidArgumentException;

/**
 * Class UserNotFoundException
 * @package App\Core\Domain\Exception\Security
 */
final class UserNotFoundException extends InvalidArgumentException
{
    /**
     * UserNotFoundException constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        parent::__construct(sprintf('User with id %s not found', $id), $code = ResponseHttpCode::HTTP_NOT_FOUND);
    }
}