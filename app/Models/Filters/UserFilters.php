<?php

namespace App\Models\Filters;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserFilters extends QueryFilters {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
        parent::__construct($request);
    }

    public function name($term) {
        return $this->builder->where('users.name', 'LIKE', "%$term%");
    }

    public function company($term) {
        return $this->builder->whereHas('company', function ($query) use ($term) {
                    return $query->where('name', 'LIKE', "%$term%");
                });
    }

    public function age($term) {
        $year = Carbon::now()->subYear($age)->format('Y');
        return $this->builder->where('dob', '>=', "$year-01-01")->where('dob', '<=', "$year-12-31");
    }

    public function sort_age($type = null) {
        return $this->builder->orderBy('dob', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }

}
