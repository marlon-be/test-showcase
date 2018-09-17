<?php

namespace App\Testing;

trait InMemoryEntityRepositoryDoctrineMethodsTrait
{
    public function find($id, $lockMode = null, $lockVersion = null) : ?object
    {
        return $this->entities->find(function ($entity) use ($id) {
            return $entity->getId() == $id;
        });
    }

    public function findAll() : array
    {
        return $this->entities->toArray();
    }

    /**
     * @throws \RuntimeException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {
        throw new \RuntimeException('In-memory repository does not allow findBy for now. Write your own filtering logic on the findAll resultset.');
    }

    /**
     * @throws \RuntimeException
     */
    public function findOneBy(array $criteria) {
        throw new \RuntimeException('In-memory repository does not allow findOneBy for now. Write your own filtering logic on the findAll resultset.');
    }

    /**
     * @throws \RuntimeException
     */
    public function getClassName() {
        throw new \RuntimeException('No metadata available when using in-memory repository implementations.');
    }
}
