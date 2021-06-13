<?php

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