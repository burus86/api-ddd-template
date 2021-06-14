<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

interface PaginatorInterface
{
    public const CURRENT_PAGE = 1;
    public const PAGE_SIZE = 50;

    public function paginate(int $page = self::CURRENT_PAGE);

    public function getCurrentPage();

    public function getLastPage();

    public function getPageSize();

    public function hasPreviousPage();

    public function getPreviousPage();

    public function hasNextPage();

    public function getNextPage();

    public function hasToPaginate();

    public function getNumResults();

    public function getResults();
}
