<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository\Doctrine;

use App\Shared\Domain\Repository\BaseEntityRepositoryInterface;
use App\Shared\Infrastructure\Repository\Doctrine\Traits\EntityManagerCustomMethodsRepositoryTrait;
use App\Shared\Infrastructure\Repository\Doctrine\Traits\QueryBuilderCustomMethodsRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BaseEntityRepository
 * @package App\Shared\Infrastructure\Repository\Doctrine
 * @phpstan-ignore-next-line
 */
abstract class BaseEntityRepository extends ServiceEntityRepository implements BaseEntityRepositoryInterface
{
    use EntityManagerCustomMethodsRepositoryTrait;
    use QueryBuilderCustomMethodsRepositoryTrait;

    /** @var string */
    protected string $entityClass;
    /** @var array<string> */
    protected array $filterFieldsAllowed;
    /** @var array<string> */
    protected array $sortFieldsAllowed;
    /** @var array<string> */
    protected array $sortOrdersAllowed = array('ASC', 'DESC');
    /** @var string */
    protected string $sortOrderDefault = 'ASC';
    /** @var QueryBuilder */
    protected QueryBuilder $queryBuilder;

    /**
     * BaseEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        /** @phpstan-ignore-next-line */
        parent::__construct($registry, $this->entityClass);
        $this->queryBuilder = $this->createQueryBuilder('e');
    }
}
