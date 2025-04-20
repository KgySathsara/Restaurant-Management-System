<?php

namespace App\Repositories\Interfaces;

interface ConcessionRepositoryInterface extends RepositoryInterface
{
    /**
     * Find multiple concessions by their IDs
     */
    public function findMany(array $ids);
}
