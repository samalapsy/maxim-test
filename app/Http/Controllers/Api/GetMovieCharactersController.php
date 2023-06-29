<?php

namespace App\Http\Controllers\Api;

use App\Services\MovieService;
use App\Http\Controllers\Controller;

class GetMovieCharactersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MovieService $movieService, $movie_id)
    {
        $data = $movieService->getMovieCharacters($movie_id);
        request()->has('gender'); //;
        request()->has('sort');
        request()->has('sort_direction');

        return response()->json($data);
    }
}
