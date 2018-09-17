<?php

namespace spec\App\Entity;

use App\Email\CompanyEmailAddress;
use App\Entity\Company;
use App\Entity\Participant;
use PhpSpec\ObjectBehavior;

/**
 * This a very basic spec test. It tests whether or not the Participant entity retains its data (before being persisted)
 * Note that some objects are easily mocked ($company), while others are not (the email address)
 * Adding logic to mocked objects in specs is possible, but a bit of a pain, so it is usually better to move tests that require it to PHPUnit tests
 * Tests like these, however, can easily be left out (unless you use specs to write code), as bugs here would be caught in other tests
 *
 * @mixin Participant
 */
class ParticipantSpec extends ObjectBehavior
{
    public function let(Company $company) : void
    {
        $this->beConstructedWith($company, new CompanyEmailAddress('some@email.com'), 'a participant');
    }

    function it_is_initializable() : void
    {
        $this->shouldHaveType(Participant::class);
    }

    function it_has_a_company(Company $company) : void
    {
        $this->getCompany()->shouldBe($company);
    }

    function it_has_an_email_address() : void
    {
        $this->getEmail()->shouldBeLike(new CompanyEmailAddress('some@email.com'));
    }

    function it_has_a_name() : void
    {
        $this->getName()->shouldBe('a participant');
    }
}
