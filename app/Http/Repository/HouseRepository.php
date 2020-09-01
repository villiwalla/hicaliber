<?php

namespace App\Http\Repository;

use App\House;
use Illuminate\Database\Eloquent\Builder;

class HouseRepository
{

    /**
     * Get house model query builder.
     *
     * @return Builder<House>
     */
    public function query(): Builder
    {
        return House::query();
    }
}
