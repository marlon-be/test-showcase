<?php

namespace App\Repository\Interfaces;

use App\Entity\Company;

interface CompanyRepository
{
    public function find($id);
    public function findBy(array $criteria);
    public function findOneBy(array $criteria);
    public function findAll();
    public function add(Company $company) : void;
}
