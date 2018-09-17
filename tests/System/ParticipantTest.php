<?php

namespace App\Tests\System;

use App\CommandBus\Command\CreateParticipantCommand;
use App\DataProvider\ParticipantDataProvider;
use App\Repository\Interfaces\CompanyRepository;
use App\Repository\Interfaces\ParticipantRepository;
use App\Tests\AbstractKernelTest;

/**
 * This is a kernel test, it uses an actual database to query
 * The upside of these kind of tests are that they are very close to the real deal, if something is wrong, this test will probably catch it
 * There are 3 big downsides of these kind of tests
 *  - though a lot of bugs will be caught by this test, it will not help a lot with finding what actually went wrong
 *  - these tests can take a long while to set up (e.g. if you have a lot of data that needs to be set up)
 *  - getting these tests to run on CI servers can be tricky
 *
 * @covers \App\CommandBus\Handler\CreateParticipantCommandHandler
 * @covers \App\Email\ParticipantNameGenerator
 */
class ParticipantTest extends AbstractKernelTest
{
    /** @var ParticipantRepository */
    private $participantRepository;
    /** @var CompanyRepository */
    private $companyRepository;

    /** @test */
    public function it_should_add_a_new_participant() : void
    {
        $command = $this->createCommand();
        $this->handleCommand($command);

        $participants = $this->participantRepository->findAll();

        self::assertCount(1, $participants);
    }

    /** @test */
    public function it_should_add_a_new_participant_to_an_existing_company() : void
    {
        $this->addDefaultParticipant();

        $command = $this->createCommand('test@marlon.be');
        $this->handleCommand($command);

        $participants = $this->participantRepository->findAll();
        $companies = $this->companyRepository->findAll();

        self::assertCount(2, $participants);
        self::assertCount(1, $companies);
    }

    /** @test */
    public function it_should_add_a_new_participant_with_an_existing_name() : void
    {
        $this->addDefaultParticipant();

        $command = $this->createCommand('admin@test.be');
        $this->handleCommand($command);

        $participants = $this->participantRepository->findAll();
        $companies = $this->companyRepository->findAll();

        self::assertCount(2, $participants);
        self::assertCount(2, $companies);

        self::assertEquals('Admin', $participants[0]->getName());
        self::assertEquals('Admin 2', $participants[1]->getName());
    }

    public function createCommand(string $email = null) : CreateParticipantCommand
    {
        return new CreateParticipantCommand($email ?? 'admin@marlon.be');
    }

    public function addDefaultParticipant() : void
    {
        $dataProvider = new ParticipantDataProvider();
        $participant = $dataProvider->createParticipant();
        $this->companyRepository->add($participant->getCompany());
        $this->participantRepository->add($participant);
        $this->em->flush();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->participantRepository = $this->getContainer()->get(ParticipantRepository::class);
        $this->companyRepository = $this->getContainer()->get(CompanyRepository::class);

    }
}

