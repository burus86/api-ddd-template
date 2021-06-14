<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

/**
 * Interface BaseEntityInterface
 * @package App\Shared\Domain\Interfaces
 */
interface BaseEntityInterface
{
    public function __toString(): string;
}
