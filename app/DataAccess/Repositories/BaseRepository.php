<?php declare(strict_types=1);

namespace App\DataAccess\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    abstract protected function getTable(): string;

    public function query(): Builder
    {
        return DB::table($this->getTable());
    }
}
