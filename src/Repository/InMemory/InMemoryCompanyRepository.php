<?php

namespace App\Repository\InMemory;

use App\Entity\Company;
use App\Repository\Interfaces;
use App\Testing\InMemoryEntityRepositoryDoctrineMethodsTrait;
use App\Testing\InMemoryEntityRepositoryTrait;

class InMemoryCompanyRepository implements Interfaces\CompanyRepository
{
    use InMemoryEntityRepositoryTrait;
    use InMemoryEntityRepositoryDoctrineMethodsTrait;

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entities->filter(function (Company $company) use ($criteria) {
            foreach ($criteria as $field => $value) {
                switch ($field) {
                    case 'name':
                        return (string) $company->getName() === (string) $value;
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

    public function add(Company $company): void
    {
        $this->entities->add($company);
    }
}
