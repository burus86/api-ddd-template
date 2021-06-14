<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model\Traits;

use DateTime;

/**
 * Trait TimestampableEntityTrait
 * @package App\Shared\Domain\Model\Traits
 */
trait TimestampableEntityTrait
{
    /**
     * @var DateTime
     */
    protected $createdAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}