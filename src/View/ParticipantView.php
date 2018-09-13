<?php

namespace App\View;

final class ParticipantView
{
    public $name;
    public $email;
    public $company;

    public function __construct(string $name, string $email, string $company)
    {
        $this->name = $name;
        $this->email = $email;
        $this->company = $company;
    }
}
