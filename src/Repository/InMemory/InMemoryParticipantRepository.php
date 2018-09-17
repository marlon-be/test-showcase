<?php

namespace App\Repository\InMemory;

use App\Entity\Participant;
use App\Repository\Interfaces\ParticipantRepository;
use App\Testing\InMemoryEntityRepositoryDoctrineMethodsTrait;
use App\Testing\InMemoryEntityRepositoryTrait;

class InMemoryParticipantRepository implements ParticipantRepository
{
    use InMemoryEntityRepositoryTrait;
    use InMemoryEntityRepositoryDoctrineMethodsTrait;

    public function findBy(array $criteria)
    {
        return $this->entities->filter(function (Participant $participant) use ($criteria) {
            foreach ($criteria as $field => $value) {
                switch ($field) {
                    case 'name':
                        return strtolower($participant->getName()) === strtolower($value);

                    case 'email':
                        return strtolower($participant->getEmail()) === strtolower($value);

                    default:
                        throw new \RuntimeException('Unknown field: ' . $field);
                }
            }
        });
    }

    public function findOneBy(array $criteria)
    {
        $results = $this->findBy($criteria);
        return reset($results);
    }

    public function findAll()
    {
        return $this->entities->toArray();
    }

    public function find($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function isNameTaken(string $name): bool
    {
        /** @var Participant $entity */
        foreach ($this->entities->toArray() as $entity) {
            if (strtolower($entity->getName()) === strtolower($name)) {
                return true;
            }
        }

        return false;
    }

    public function fetchAll(): array
    {
        return $this->entities->toArray();
    }

    public function add(Participant $participant): void
    {
        $this->entities->add($participant);
    }
}
