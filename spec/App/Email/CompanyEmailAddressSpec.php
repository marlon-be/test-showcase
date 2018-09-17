<?php

namespace spec\App\Email;

use App\Email\CompanyEmailAddress;
use PhpSpec\ObjectBehavior;

/**
 * This is a spec test, they are preferably written before the actual code, but can still have merit if written later
 * These tests are best used for small blocks of functionality in isolated classes
 * Objects can be mocked here, but it is discouraged
 *
 * @mixin CompanyEmailAddress
 */
class CompanyEmailAddressSpec extends ObjectBehavior
{
    public function let() : void
    {
        $this->beConstructedWith('mar.lon@marlon-be.be');
    }

    function it_is_initializable() : void
    {
        $this->shouldHaveType(CompanyEmailAddress::class);
    }

    function it_should_have_a_name() : void
    {
        $this->getName()->shouldBe('mar.lon');
    }

    function it_should_have_a_domain() : void
    {
        $this->getDomain()->shouldBe('marlon-be');
    }

    function it_should_have_an_email_address() : void
    {
        $this->getAddress()->shouldBe('mar.lon@marlon-be.be');
    }
}
