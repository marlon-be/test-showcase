<?php

namespace App\Repository\InMemory;

use App\Entity\Company;
use App\Repository\Interfaces\CompanyRepository;
use App\Testing\InMemoryEntityRepositoryDoctrineMethodsTrait;
use App\Testing\InMemoryEntityRepositoryTrait;

class InMemoryCompanyRepository implements CompanyRepository
{
    use InMemoryEntityRepositoryTrait;
    use InMemoryEntityRepositoryDoctrineMethodsTrait;

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entities->filter(function (Company $company) use ($criteria) {
            foreach ($criteria as $field => $value) {
                switch ($field) {
                    case 'name':
                        return strtolower($company->getName()) === strtolower($value);

                    default:
                        throw new \RuntimeException('Unknown field: ' . $field);
                }
            }
        });
    }

    public function findOneBy(array $criteria)
    {
        $results = $this->findBy($criteria);
        return reset($results) ?: null;
    }

    public function findAll()
    {
        return $this->entities->toArray();
    }

    public function find($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function add(Company $company): void
    {
        $this->entities->add($company);
    }
}
