<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller\Traits;

use App\Shared\Infrastructure\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait RequestHelpersControllerTrait
 * @package App\Shared\Infrastructure\Controller\Traits
 */
trait RequestHelpersControllerTrait
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    protected function getRequestFilters(Request $request): array
    {
        $result = [];
        $params = $request->query->all();
        foreach ($params as $field => $value) {
            if (!in_array($field, ['sort_field', 'sort_order'])) {
                $result = array_merge($result, [$field => $value]);
            }
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    protected function getRequestOrderBy(Request $request): array
    {
        $result = [];
        $params = $request->query->all();
        foreach ($params as $field => $value) {
            if (in_array($field, ['sort_field', 'sort_order'])) {
                $result = array_merge($result, [$field => $value]);
            }
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return int
     */
    protected function getRequestCurrentPage(Request $request): int
    {
        return $this->getRequestPageParams($request, 'page', Paginator::CURRENT_PAGE);
    }

    /**
     * @param Request $request
     * @return int
     */
    protected function getRequestPageSize(Request $request): int
    {
        return $this->getRequestPageParams($request, 'page_size', Paginator::PAGE_SIZE);
    }

    /**
     * @param Request $request
     * @param string $pageParam
     * @param int $defaultValue
     * @return int
     */
    private function getRequestPageParams(Request $request, string $pageParam, int $defaultValue): int
    {
        $params = $request->query->all();
        foreach ($params as $field => $value) {
            if ($value && strcmp($field, $pageParam) === 0) {
                if (!filter_var($value, FILTER_VALIDATE_INT)) {
                    throw new InvalidArgumentException(
                        "{$pageParam} value must be an integer!",
                        Response::HTTP_BAD_REQUEST
                    );
                }
                return $value;
            }
        }
        return $defaultValue;
    }
}
