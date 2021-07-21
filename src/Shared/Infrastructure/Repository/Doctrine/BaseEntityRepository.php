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
 */
abstract class BaseEntityRepository extends ServiceEntityRepository implements BaseEntityRepositoryInterface
{
    use EntityManagerCustomMethodsRepositoryTrait;
    use QueryBuilderCustomMethodsRepositoryTrait;

    /** @var string */
    protected $entityClass;
    /** @var array<string> */
    protected $filterFieldsAllowed;
    /** @var array<string> */
    protected $sortFieldsAllowed;
    /** @var array<string> */
    protected $sortOrdersAllowed = array('ASC', 'DESC');
    /** @var string */
    protected $sortOrderDefault = 'ASC';
    /** @var QueryBuilder */
    protected $queryBuilder;

    /**
     * BaseEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->entityClass);
        $this->queryBuilder = $this->createQueryBuilder('e');
    }
}
