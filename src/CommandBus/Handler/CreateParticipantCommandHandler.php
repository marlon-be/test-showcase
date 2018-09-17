<?php

namespace App\CommandBus\Handler;

use App\CommandBus\Command\CreateParticipantCommand;
use App\Email\MailNameFormatter;
use App\Email\ParticipantNameGenerator;
use App\Entity\Company;
use App\Entity\Participant;
use App\Repository\Interfaces\CompanyRepository;
use App\Repository\Interfaces\ParticipantRepository;

class CreateParticipantCommandHandler
{
    private $participantRepository;
    private $companyRepository;
    private $participantNameGenerator;

    public function __construct(
        ParticipantRepository $participantRepository,
        CompanyRepository $companyRepository,
        ParticipantNameGenerator $participantNameGenerator
    ) {
        $this->participantRepository = $participantRepository;
        $this->companyRepository = $companyRepository;
        $this->participantNameGenerator = $participantNameGenerator;
    }

    public function handle(CreateParticipantCommand $command) : void
    {
        $companyEmailAddress = $command->getEmail();

        $companyName = MailNameFormatter::formatName($companyEmailAddress->getDomain());
        $company = $this->companyRepository->findOneBy(['name' => $companyName]);

        if (!$company) {
            $company = new Company($companyName);
            $this->companyRepository->add($company);
        }

        $participant = new Participant(
            $company,
            $companyEmailAddress,
            $this->participantNameGenerator->generate(MailNameFormatter::formatName($companyEmailAddress->getName()))
        );

        $this->participantRepository->add($participant);
    }
}
