<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model\Traits;

/**
 * Trait IdEntityTrait
 * @package App\Shared\Domain\Model\Traits
 */
trait IdEntityTrait
{
    /**
     * @var int
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}