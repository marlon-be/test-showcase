<?php

namespace App\Repository;

use App\Entity\Company;
use App\Repository\Interfaces\CompanyRepository;
use Doctrine\ORM\EntityRepository;

/**
 * @method Company find($id, $lockMode = null, $lockVersion = null)
 * @method Company findOneBy(array $criteria, array $orderBy = null)
 * @method Company[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class DoctrineCompanyRepository extends EntityRepository implements CompanyRepository
{
    public function add(Company $company) : void
    {
        $this->_em->persist($company);
    }
}
