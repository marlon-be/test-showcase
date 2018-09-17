<?php

namespace App\Repository\Interfaces;

use App\Entity\Participant;

interface ParticipantRepository
{
    public function find($id);
    public function findBy(array $criteria);
    public function findOneBy(array $criteria);
    public function findAll();

    public function add(Participant $participant) : void;
    public function isNameTaken(string $name) : bool;
    public function fetchAll() : array;
}
