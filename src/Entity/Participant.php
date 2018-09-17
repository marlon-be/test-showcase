<?php

namespace App\Entity;

use App\Email\CompanyEmailAddress;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctrineParticipantRepository")
 * @ORM\Table(name="participant")
 */
class Participant
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     */
    private $company;
    /**
     * @ORM\Column(type="string")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct(Company $company, CompanyEmailAddress $email, string $name)
    {
        $this->company = $company;
        $this->email = $email->getAddress();
        $this->name = $name;
    }

    public function getCompany() : Company
    {
        return $this->company;
    }

    public function getEmail() : CompanyEmailAddress
    {
        return new CompanyEmailAddress($this->email);
    }

    public function getName() : string
    {
        return $this->name;
    }
}
