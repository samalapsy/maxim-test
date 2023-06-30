<?php

namespace App\Http\Controllers\Api;

use App\Services\MovieService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CharacterResource;

class GetMovieCharactersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MovieService $movieService, $movie_id)
    {
        $data = $movieService->getMovieCharacters($movie_id);
        $gender = request('gender');
        if ($gender && in_array(strtolower($gender), ['male', 'female', 'unknown', 'n/a'])) {
            $data = $data->where('gender', $gender);
        }

        $sort_by = request('sort_by');
        $sort_direction = request('sort_direction');
        if ($sort_by && in_array(strtolower($sort_by), ['name', 'height', 'gender']) && in_array(strtolower($sort_direction), ['asc', 'desc'])) {
            $data = $sort_direction == 'asc' ?  $data->sortBy($sort_by) : $data->sortByDesc($sort_by);
        }

        $characters = collect($data->all());
        $total_height = 0;

        return $this->successfulResponseWithCollection('API request successful', [
            'total' => $characters->count(),
            'total_height' => $total_height,
            'characters' => CharacterResource::collection($characters->values())
        ]);
    }
}
