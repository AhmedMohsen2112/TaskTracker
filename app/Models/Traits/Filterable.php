<?php

namespace App\Models\Traits;

use App\Models\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable {

    public function scopeFilter($query, QueryFilters $filters) {
        return $filters->apply($query);
    }

}
