<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Filters
{

    public function filterCharacters(?Collection $data): Collection
    {
        $gender = request('gender');
        if ($gender && in_array(strtolower($gender), ['male', 'female', 'unknown', 'n/a'])) {
            $data = $data->where('gender', $gender);
        }

        $sort_by = request('sort_by');
        $sort_direction = request('sort_direction');
        if ($sort_by && in_array(strtolower($sort_by), ['name', 'height', 'gender']) && in_array(strtolower($sort_direction), ['asc', 'desc'])) {
            $data = $sort_direction == 'asc' ?  $data->sortBy($sort_by) : $data->sortByDesc($sort_by);
        }

        return collect($data->all());
    }
}
