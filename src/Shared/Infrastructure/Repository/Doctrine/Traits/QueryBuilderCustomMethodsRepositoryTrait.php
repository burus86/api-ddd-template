<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository\Doctrine\Traits;

use App\Shared\Domain\Interfaces\BaseEntityInterface;
use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait QueryBuilderCustomMethodsRepositoryTrait
 * @package App\Shared\Infrastructure\Repository\Doctrine\Traits
 */
trait QueryBuilderCustomMethodsRepositoryTrait
{
    public function addSearchByStringEquals(string $fieldName, string $value, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        $key = $fieldName;
        $this->queryBuilder
            ->andWhere($this->queryBuilder->expr()->eq($this->getField($fieldName, $fieldPrefix), ":{$key}"))
            ->setParameter($key, $value)
        ;

        return $this->queryBuilder;
    }

    public function addSearchByStringContains(string $fieldName, string $value, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        $this->queryBuilder->andWhere($this->queryBuilder->expr()->like($this->getField($fieldName, $fieldPrefix), sprintf("'%%%s%%'", $value)));

        return $this->queryBuilder;
    }

    public function addSearchByStringStartsWith(string $fieldName, string $value, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        $this->queryBuilder->andWhere($this->queryBuilder->expr()->like($this->getField($fieldName, $fieldPrefix), sprintf("'%s%%'", $value)));

        return $this->queryBuilder;
    }

    public function addSearchByStringEndsWith(string $fieldName, string $value, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        $this->queryBuilder->andWhere($this->queryBuilder->expr()->like($this->getField($fieldName, $fieldPrefix), sprintf("'%%%s'", $value)));

        return $this->queryBuilder;
    }

    public function addSearchByString(string $fieldName, string $value, ?string $comparisonCondition = null, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        $comparisonCondition = $comparisonCondition ?? self::COMPARISON_CONDITION_STARTS;
        switch ($comparisonCondition) {
            case self::COMPARISON_CONDITION_EQUALS:
                return $this->addSearchByStringEquals($fieldName, $value, $fieldPrefix);
            case self::COMPARISON_CONDITION_CONTAINS:
                return $this->addSearchByStringContains($fieldName, $value, $fieldPrefix);
            case self::COMPARISON_CONDITION_STARTS:
                return $this->addSearchByStringStartsWith($fieldName, $value, $fieldPrefix);
            case self::COMPARISON_CONDITION_ENDS:
                return $this->addSearchByStringEndsWith($fieldName, $value, $fieldPrefix);
            default:
                $comparisonConditionsAllowed = join(',', self::COMPARISON_CONDITIONS_ALLOWED);
                throw new InvalidArgumentException(sprintf('Condition value "%s" is not allowed. Options available: %s', $comparisonCondition, $comparisonConditionsAllowed), $code = Response::HTTP_BAD_REQUEST);
        }
    }

    public function addSearchByFieldInInterval(string $fieldName, $minValue, $maxValue, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        if (!empty($minValue) || !empty($maxValue)) {
            $key = $fieldName;
            $field = $this->getField($fieldName, $fieldPrefix);
            $this->queryBuilder->andWhere($this->queryBuilder->expr()->isNotNull($field));
            if (!empty($minValue)) {
                $this->queryBuilder
                    ->andWhere($this->queryBuilder->expr()->gte($field, ":min_{$key}"))
                    ->setParameter("min_{$key}", $minValue);
            }
            if (!empty($maxValue)) {
                $this->queryBuilder
                    ->andWhere($this->queryBuilder->expr()->lte($field, ":max_{$key}"))
                    ->setParameter("max_{$key}", $maxValue);
            }
        }

        return $this->queryBuilder;
    }

    public function addSearchByEntity(BaseEntityInterface $entity, ?string $parameter = null): QueryBuilder
    {
        $parameter = $parameter ?? 'entity';
        $this->queryBuilder
            ->andWhere($this->queryBuilder->expr()->isNotNull('e'))
            ->andWhere($this->queryBuilder->expr()->eq('e',":{$parameter}"))
            ->setParameter($parameter, $entity)
        ;

        return $this->queryBuilder;
    }

    public function setOrderByField(string $fieldName, ?string $order = null, ?string $fieldPrefix = 'e'): QueryBuilder
    {
        $order = $order ?? 'ASC';
        return $this->queryBuilder->orderBy($this->getField($fieldName, $fieldPrefix), $order);
    }

    /**
     * @param string $fieldName
     * @param string|null $fieldPrefix
     * @return string
     */
    private function getField(string $fieldName, ?string $fieldPrefix = 'e'): string
    {
        $fieldPrefix = $fieldPrefix ?? 'e';
        return "{$fieldPrefix}.{$fieldName}";
    }
}
