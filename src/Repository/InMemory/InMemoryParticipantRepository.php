<?php

namespace App\Repository\InMemory;

use App\Entity\Participant;
use App\Repository\Interfaces;
use App\Testing\InMemoryEntityRepositoryDoctrineMethodsTrait;
use App\Testing\InMemoryEntityRepositoryTrait;

class InMemoryParticipantRepository implements Interfaces\ParticipantRepository
{
    use InMemoryEntityRepositoryTrait;
    use InMemoryEntityRepositoryDoctrineMethodsTrait;

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entities->filter(function (Participant $participant) use ($criteria) {
            foreach ($criteria as $field => $value) {
                switch ($field) {
                    case 'name':
                        return (string) $participant->getName() === (string) $value;
                        break;
                    case 'email':
                        return (string) $participant->getEmail() === (string) $value;
                        break;
                    default:
                        return false;
                }
            }
        });
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $results = $this->findBy($criteria);
        return reset($results);
    }

    public function findAll()
    {
        return $this->entities->toArray();
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function isNameTaken(string $name): bool
    {
        foreach ($this->entities->toArray() as $entity) {
            if ($entity->getName() === $name) {
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
