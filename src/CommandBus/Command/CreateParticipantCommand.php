<?php

namespace App\CommandBus\Command;

use App\CommandBus\Command;
use App\Email\CompanyEmailAddress;

class CreateParticipantCommand implements Command
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail() : CompanyEmailAddress
    {
        return new CompanyEmailAddress($this->email);
    }
}
