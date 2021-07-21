<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller\Traits;

use App\Shared\Domain\Interfaces\PaginatorInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait JsonResponseHelpersControllerTrait
 * @package App\Shared\Infrastructure\Controller\Traits
 */
trait JsonResponseHelpersControllerTrait
{
    /**
     * @param array<string, mixed> $data
     * @param int|null $status
     * @return JsonResponse
     */
    protected function getApiSuccessJsonResponse(array $data, ?int $status = null): JsonResponse
    {
        $status = $status ?? Response::HTTP_OK;
        return $this->getApiJsonResponse($data, $status, $success = true);
    }

    /**
     * @param PaginatorInterface $collection
     * @param string $message
     * @return JsonResponse
     */
    protected function getApiSuccessCollectionJsonResponse(
        PaginatorInterface $collection,
        string $message
    ): JsonResponse {
        $records = iterator_to_array($collection->getResults());
        $data = array(
            'message' => $message,
            'page_size' => $collection->getPageSize(),
            'num_results' => $collection->getNumResults(),
            'page' => "{$collection->getCurrentPage()} of {$collection->getLastPage()}",
            'data' => $this->renderRecords($records),
        );
        return $this->getApiSuccessJsonResponse($data);
    }

    /**
     * @param Exception $exception
     * @param int|null $status
     * @return JsonResponse
     */
    protected function getApiErrorJsonResponse(
        Exception $exception,
        ?int $status = null
    ): JsonResponse {
        $status = $status ?? Response::HTTP_BAD_REQUEST;
        $data = array('message' => $exception->getMessage());
        return $this->getApiJsonResponse($data, $status, $success = false);
    }

    /**
     * @param array<string, mixed> $data
     * @param int $status
     * @param bool|null $success
     * @return JsonResponse
     */
    private function getApiJsonResponse(array $data, int $status, $success = true): JsonResponse
    {
        $result = array('success' => $success);
        if (is_array($data) && count($data) > 0) {
            $result = array_merge($result, $data);
        }

        return $this->json($result, $status);
    }
}
