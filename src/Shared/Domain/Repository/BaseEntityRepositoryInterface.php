<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Interfaces\BaseEntityInterface;
use InvalidArgumentException;

/**
 * Interface BaseEntityRepositoryInterface
 * @package App\Shared\Domain\Repository
 */
interface BaseEntityRepositoryInterface
{
    public const COMPARISON_CONDITION_EQUALS = "EQUALS";
    public const COMPARISON_CONDITION_CONTAINS = "CONTAINS";
    public const COMPARISON_CONDITION_STARTS = "STARTS";
    public const COMPARISON_CONDITION_ENDS = "ENDS";
    public const COMPARISON_CONDITIONS_ALLOWED = [
        self::COMPARISON_CONDITION_EQUALS, self::COMPARISON_CONDITION_CONTAINS, self::COMPARISON_CONDITION_STARTS, self::COMPARISON_CONDITION_ENDS
    ];

    public function insert(BaseEntityInterface $entity);

    public function update();

    public function delete(BaseEntityInterface $entity);

    /**
     * @param string $fieldName
     * @param string $value
     * @param string|null $fieldPrefix
     * @return mixed
     */
    public function addSearchByStringEquals(string $fieldName, string $value, ?string $fieldPrefix = 'e');

    /**
     * @param string $fieldName
     * @param string $value
     * @param string|null $fieldPrefix
     * @return mixed
     */
    public function addSearchByStringContains(string $fieldName, string $value, ?string $fieldPrefix = 'e');

    /**
     * @param string $fieldName
     * @param string $value
     * @param string|null $fieldPrefix
     * @return mixed
     */
    public function addSearchByStringStartsWith(string $fieldName, string $value, ?string $fieldPrefix = 'e');

    /**
     * @param string $fieldName
     * @param string $value
     * @param string|null $fieldPrefix
     * @return mixed
     */
    public function addSearchByStringEndsWith(string $fieldName, string $value, ?string $fieldPrefix = 'e');

    /**
     * @param string $fieldName
     * @param string $value
     * @param string|null $comparisonCondition
     * @param string|null $fieldPrefix
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function addSearchByString(string $fieldName, string $value, ?string $comparisonCondition = null, ?string $fieldPrefix = 'e');

    /**
     * @param string $fieldName
     * @param mixed $minValue
     * @param mixed $maxValue
     * @param string|null $fieldPrefix
     * @return mixed
     */
    public function addSearchByFieldInInterval(string $fieldName, $minValue, $maxValue, ?string $fieldPrefix = 'e');

    /**
     * @param BaseEntityInterface $entity
     * @param string|null $parameter
     * @return mixed
     */
    public function addSearchByEntity(BaseEntityInterface $entity, ?string $parameter = null);

    /**
     * @param string $fieldName
     * @param string|null $order
     * @param string|null $fieldPrefix
     * @return mixed
     */
    public function setOrderByField(string $fieldName, ?string $order = null, ?string $fieldPrefix = 'e');
}