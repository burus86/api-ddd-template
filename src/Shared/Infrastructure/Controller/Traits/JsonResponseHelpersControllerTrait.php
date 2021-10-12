<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller\Traits;

use App\Shared\Domain\Interfaces\PaginatorInterface;
use App\Shared\Domain\Interfaces\ResponseHttpCode;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $status = $status ?? ResponseHttpCode::HTTP_OK;
        $data = array_merge(array('success' => true), $data);
        return $this->json($data, $status);
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
        $status = $status ?? ResponseHttpCode::HTTP_BAD_REQUEST;
        $data = array(
            'success' => false,
            'message' => $exception->getMessage()
        );
        return $this->json($data, $status);
    }
}
