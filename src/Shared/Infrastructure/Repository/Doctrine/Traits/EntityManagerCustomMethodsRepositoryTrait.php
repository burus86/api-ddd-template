<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository\Doctrine\Traits;

use App\Shared\Domain\Interfaces\BaseEntityInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Persisters\PersisterException;

/**
 * Trait EntityManagerCustomMethodsRepositoryTrait
 * @package App\Shared\Infrastructure\Repository\Doctrine\Traits
 */
trait EntityManagerCustomMethodsRepositoryTrait
{
    /**
     * @param BaseEntityInterface $entity
     * @throws PersisterException
     */
    public function insert(BaseEntityInterface $entity): void
    {
        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        } catch (ORMException $exception) {
            throw new PersisterException();
        }
    }

    /**
     * @throws PersisterException
     */
    public function update(): void
    {
        try {
            $this->getEntityManager()->flush();
        } catch (ORMException $exception) {
            throw new PersisterException();
        }
    }

    /**
     * @param BaseEntityInterface $entity
     * @throws PersisterException
     */
    public function delete(BaseEntityInterface $entity): void
    {
        try {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        } catch (ORMException $exception) {
            throw new PersisterException();
        }
    }
}
