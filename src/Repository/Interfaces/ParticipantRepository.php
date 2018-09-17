<?php

namespace App\Repository\Interfaces;

use App\Entity\Participant;

interface ParticipantRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function findOneBy(array $criteria, array $orderBy = null);
    public function findAll();

    public function add(Participant $participant) : void;
    public function isNameTaken(string $name) : bool;
    public function fetchAll() : array;
}
