<?php

namespace App\Repositories\Eloquent;

use App\Models\Concession;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ConcessionRepository extends BaseRepository implements ConcessionRepositoryInterface
{
    public function __construct(Concession $model)
    {
        parent::__construct($model);
    }

    public function findMany(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
