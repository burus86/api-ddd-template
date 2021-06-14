<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\Traits\JsonResponseHelpersControllerTrait;
use App\Shared\Infrastructure\Controller\Traits\RequestHelpersControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController
 * @package App\Shared\Infrastructure\Controller
 */
abstract class BaseController extends AbstractController
{
    protected $service;
    protected $loggedUserId;

    use JsonResponseHelpersControllerTrait, RequestHelpersControllerTrait;

    /**
     * @param array $collection
     * @return array
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
