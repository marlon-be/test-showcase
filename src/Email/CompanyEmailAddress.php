<?php

namespace App\Email;

final class CompanyEmailAddress
{
    private $address;

    public function __construct(string $address)
    {
        if (!\filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address: ' . $address);
        }

        $this->address = $address;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function getName() : string
    {
        return \explode('@', $this->address, 2)[0];
    }

    public function getDomain() : string
    {
        $domainStartPos = \strpos($this->address, '@') + 1;
        $topDomainPos = \strrpos($this->address, '.');

        return \substr($this->address, $domainStartPos, $topDomainPos - $domainStartPos);
    }
}
