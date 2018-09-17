<?php

namespace App\DataProvider;

use App\Email\CompanyEmailAddress;
use App\Entity\Company;
use App\Entity\Participant;

class ParticipantDataProvider
{
    public static function createParticipant() : Participant
    {
        return new Participant(
            self::createCompany(),
            self::createCompanyEmailAddress(),
            'Admin'
        );
    }

    public static function createCompany() : Company
    {
        return new Company('Marlon');
    }

    public static function createCompanyEmailAddress() : CompanyEmailAddress
    {
        return new CompanyEmailAddress('admin@marlon.be');
    }
}
