<?php

namespace App\Tests\Email;

use App\Email\ParticipantNameGenerator;
use App\Repository\DoctrineParticipantRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * This is a service test
 * We try to avoid this because it causes a lot of internal coupling, and it often requires a lot of mocking
 *
 * @see \spec\App\Email\MailNameFormatterSpec
 */
final class ParticipantNameGeneratorTest extends TestCase
{
    /** @var DoctrineParticipantRepository */
    private $participantRepository;
    /** @var ParticipantNameGenerator */
    private $generator;

    /** @test */
    public function it_should_return_name_if_not_taken() : void
    {
        $name = $this->generator->generate('some name');

        self::assertEquals('some name', $name);
    }

    /** @test */
    public function it_should_return_incremented_name_if_taken() : void
    {
        $this->participantRepository->isNameTaken('some name')->willReturn(true);
        $this->participantRepository->isNameTaken('some name 2')->willReturn(true);
        $this->participantRepository->isNameTaken('some name 3')->willReturn(true);

        $name = $this->generator->generate('some name');

        self::assertEquals('some name 4', $name);
    }

    protected function setUp() : void
    {
        $this->participantRepository = $this->prophesize(DoctrineParticipantRepository::class);
        $this->generator = new ParticipantNameGenerator(
            $this->participantRepository->reveal()
        );

        // These kind of methods protect your tests during internal renames (e.g. when using findBy)
        // But they fill up your repository
        $this->participantRepository->isNameTaken(Argument::any())->willReturn(false);
    }
}
