<?php

namespace App\Email;


use App\Repository\Interfaces\ParticipantRepository;

final class ParticipantNameGenerator
{
    private $participantRepository;

    public function __construct(ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    public function generate(string $name) : string
    {
        $increment = 0;

        do {
            $testName = $name . ($increment++ ? ' ' . $increment : '');
        } while ($this->participantRepository->isNameTaken($testName));

        return $testName;
    }
}
