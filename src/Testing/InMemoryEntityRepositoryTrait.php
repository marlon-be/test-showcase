<?php

namespace App\Testing;

trait InMemoryEntityRepositoryTrait
{
    public $entities;

    public function __construct()
    {
        $this->entities = new InMemoryEntityCollection();
        $this->entities->enableAutoIncrementId();
    }
}
