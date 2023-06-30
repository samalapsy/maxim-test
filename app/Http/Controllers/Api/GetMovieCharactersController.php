<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Services\MovieService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CharacterResource;
use App\Traits\Filters;

class GetMovieCharactersController extends Controller
{
    use Filters;

    /**
     * Handle the incoming request.
     */
    public function __invoke(MovieService $movieService, $movie_id)
    {
        try {
            $data = $movieService->getMovieCharacters($movie_id);
            $characters = $this->filterCharacters($data);
            $total_height = 0;
            return $this->successfulResponseWithCollection('API request successful', [
                'total' => $characters->count(),
                'total_height' => $total_height,
                'characters' => CharacterResource::collection($characters->values())
            ]);
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception->getMessage(), $exception);
        }
    }
}
