<?php

namespace App\DataProvider;

use App\Email\CompanyEmailAddress;
use App\Entity\Company;
use App\Entity\Participant;

class ParticipantDataProvider
{
    public function createParticipant() : Participant
    {
        return new Participant(
            $this->createCompany(),
            $this->createCompanyEmailAddress(),
            'Admin'
        );
    }

    public function createCompany() : Company
    {
        return new Company('Marlon');
    }

    public function createCompanyEmailAddress() : CompanyEmailAddress
    {
        return new CompanyEmailAddress('admin@marlon.be');
    }
}
