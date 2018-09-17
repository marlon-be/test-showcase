<?php

namespace spec\App\Email;

use App\Email\MailNameFormatter;
use PhpSpec\ObjectBehavior;

/**
 * This is a spec test for a static class
 * Since this is an isolated class, spec tests would be great
 * However, when you want to test large sets of data, it can be easier to use a PHPUnit tests
 * @see \App\Tests\Email\ParticipantNameGeneratorTest
 *
 * @mixin MailNameFormatter
 */
class MailNameFormatterSpec extends ObjectBehavior
{
    function it_is_initializable() : void
    {
        $this->shouldHaveType(MailNameFormatter::class);
    }

    function it_should_format_a_string() : void
    {
        $this->formatName('mar-lon.be')->shouldBe('Mar Lon Be');
    }
}
