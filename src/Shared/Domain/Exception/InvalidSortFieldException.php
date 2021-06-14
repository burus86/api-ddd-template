<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use App\Shared\Domain\Interfaces\ResponseHttpCode;
use InvalidArgumentException;

/**
 * Class InvalidSortFieldException
 * @package App\Shared\Domain\Exception
 */
final class InvalidSortFieldException extends InvalidArgumentException
{
    /**
     * InvalidSortFieldException constructor.
     * @param string $field
     * @param array $options
     */
    public function __construct(string $field, array $options)
    {
        $allowedOptions = implode(', ', $options);
        parent::__construct(sprintf('Sort field by "%s" is invalid. It should be one value from: %s', $field, $allowedOptions), $code = ResponseHttpCode::HTTP_BAD_REQUEST);
    }
}