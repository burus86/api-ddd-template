<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Interfaces\BaseEntityInterface;
use App\Shared\Domain\Model\Traits\IdEntityTrait;
use App\Shared\Domain\Model\Traits\TimestampableEntityTrait;
use DateTime;

/**
 * Class AbstractEntity
 * @package App\Shared\Domain\Model
 */
abstract class AbstractEntity implements BaseEntityInterface
{
    use IdEntityTrait, TimestampableEntityTrait;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }
}
