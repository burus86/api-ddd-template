<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

use Traversable;

interface PaginatorInterface
{
    public const CURRENT_PAGE = 1;
    public const PAGE_SIZE = 50;

    public function paginate(int $page = self::CURRENT_PAGE): self;

    public function getCurrentPage(): int;

    public function getLastPage(): int;

    public function getPageSize(): int;

    public function hasPreviousPage(): bool;

    public function getPreviousPage(): int;

    public function hasNextPage(): bool;

    public function getNextPage(): int;

    public function hasToPaginate(): bool;

    public function getNumResults(): int;

    public function getResults(): Traversable;
}
