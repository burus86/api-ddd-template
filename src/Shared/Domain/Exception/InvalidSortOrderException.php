<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use App\Shared\Domain\Interfaces\ResponseHttpCode;
use InvalidArgumentException;

/**
 * Class InvalidSortOrderException
 * @package App\Shared\Domain\Exception
 */
final class InvalidSortOrderException extends InvalidArgumentException
{
    /**
     * InvalidSortOrderException constructor.
     * @param string $field
     * @param array $options
     */
    public function __construct(string $field, array $options)
    {
        $allowedOptions = implode(', ', $options);
        parent::__construct(sprintf('Sort criteria by "%s" is invalid. It should be one value from: %s', $field, $allowedOptions), $code = ResponseHttpCode::HTTP_BAD_REQUEST);
    }
}