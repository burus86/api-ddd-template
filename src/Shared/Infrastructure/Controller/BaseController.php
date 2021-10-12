<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Application\Service\ApplicationServiceInterface;
use App\Shared\Infrastructure\Controller\Traits\JsonResponseHelpersControllerTrait;
use App\Shared\Infrastructure\Controller\Traits\RequestHelpersControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController
 * @package App\Shared\Infrastructure\Controller
 */
abstract class BaseController extends AbstractController
{
    use JsonResponseHelpersControllerTrait;
    use RequestHelpersControllerTrait;

    /** @var ApplicationServiceInterface */
    protected ApplicationServiceInterface $service;
    /** @var int|null */
    protected ?int $loggedUserId;

    /**
     * @param array<int, mixed> $collection
     * @return array<int, mixed>
     */
    protected function renderRecords(array $collection): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = $item->toArray();
        }
        return $result;
    }
}
