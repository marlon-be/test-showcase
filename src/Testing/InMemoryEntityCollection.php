<?php

namespace App\Testing;

class InMemoryEntityCollection implements \Countable
{
    private $entities = [];
    private $autoIncrementId = false;
    private $id = 1;

    public function enableAutoIncrementId() : void
    {
        $this->autoIncrementId = true;
    }

    public function add($entity) : void
    {
        if ($this->autoIncrementId) {
            if (method_exists($entity, 'forceId')) {
                $entity->forceId($this->id++);
            }
        }
        $this->entities[] = $entity;
    }

    public function remove($entity) : void
    {
        $this->entities = array_values(array_filter($this->entities, function ($e) use ($entity) {
            return $e !== $entity;
        }));
    }

    public function addMultiple(array $entities) : void
    {
        foreach ($entities as $entity) {
            $this->add($entity);
        }
    }

    public function filter($fn) : array
    {
        return array_values(array_filter($this->entities, $fn));
    }

    public function find($fn) : ?object
    {
        foreach ($this->entities as $entity) {
            if ($fn($entity)) {
                return $entity;
            }
        }

        return null;
    }

    public function toArray() : array
    {
        return $this->entities;
    }

    public function getOnly() : object
    {
        \assert(\count($this) === 1);

        return reset($this->entities);
    }

    public function clear() : void
    {
        $this->entities = [];
    }

    public function count() : int
    {
        return \count($this->entities);
    }
}
