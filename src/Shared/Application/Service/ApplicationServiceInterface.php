<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Shared\Application\Request\ApplicationRequestInterface;

/**
 * Interface ApplicationServiceInterface
 * @package App\Shared\Application\Service
 */
interface ApplicationServiceInterface
{
    /**
     * @param ApplicationRequestInterface $request
     * @return mixed
     */
    public function execute(ApplicationRequestInterface $request);
}