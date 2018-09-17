<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\ORM\EntityRepository;

/**
 * @method Participant find($id, $lockMode = null, $lockVersion = null)
 * @method Participant findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineParticipantRepository extends EntityRepository implements Interfaces\ParticipantRepository
{
    public function add(Participant $participant) : void
    {
        $this->_em->persist($participant);
    }

    public function isNameTaken(string $name) : bool
    {
        $qb = $this->createQueryBuilder('participant');
        $qb ->select('count(participant.id)')
            ->where('participant.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }

    public function fetchAll() : array
    {
        $qb = $this->createQueryBuilder('participant');
        $qb ->select(['participant.name', 'participant.email', 'company.name as company_name'])
            ->innerJoin('participant.company', 'company')
            ->orderBy('company.name', 'ASC')
            ->orderBy('participant.name', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }
}
