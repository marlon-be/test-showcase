<?php

namespace App\CommandBus\Command;

use App\CommandBus\Command;

class CreateParticipantCommand implements Command
{
    private $email;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email) : void
    {
        $this->email = $email;
    }
}
