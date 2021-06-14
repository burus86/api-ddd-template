<?php

declare(strict_types=1);

namespace App\Core\Application\Service\Security;

use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Service\ApplicationServiceInterface;

/**
 * Class UserService
 * @package App\Core\Application\Service\Security
 */
abstract class UserService implements ApplicationServiceInterface
{
    /** @var UserRepositoryInterface $repository */
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}