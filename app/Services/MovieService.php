<?php

namespace App\Services;

use Exception;
use App\Models\Comment;;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MovieService
{
    /**
     * Get all movies with total comments per movie.
     *
     * @return Collection
     */
    public function getMoviesWithCommentCounts(): Collection
    {
        $movies =  collect($this->fetchMovies());
        $movie_comments = Comment::select('movie_id')->get()->groupBy('movie_id');
        return $movies->sortBy('release_date')
            ->map(function ($movie) use ($movie_comments) {
                return [
                    'title' => $movie->title,
                    'opening_crawl' => $movie->opening_crawl,
                    'comments_count' => $movie_comments->count() > 0 && isset($movie_comments[$movie->id]) ? count($movie_comments[$movie->id]) : 0
                ];
            });
    }

    /**
     * Get all the characters in a movie
     *
     * @param integer $movie_id
     * @return Collection
     */
    public function getMovieCharacters(int $movie_id): Collection
    {
        $movie = collect($this->findMovie($movie_id));
        $key = $movie_id . '-characters';
        $data = collect($movie['characters']);
        $characters = Cache::remember($key . '2', config('maxim.cache_duration'), function () use ($data) {
            $responses = Http::pool(function (Pool $pool) use ($data) {
                return $data->map(fn ($character) => $pool->get($character));
            });

            $all_characters = [];
            foreach ($responses as $response) {
                if ($response->ok()) {
                    array_push($all_characters, $response->object());
                }
            }

            return $all_characters;
        });

        return collect($characters);
    }

    /**
     * Find a movie by the id sent
     *
     * @param integer $movie_id
     * @return Collection|null
     */
    public function findMovie(int $movie_id): ?Collection
    {
        $movie = collect($this->fetchMovies())->firstWhere('id', $movie_id);
        return $movie ? collect($movie) : null;
    }

    /**
     * Get all the movie comments.
     *
     * @param integer $movie_id
     * @return Collection|null
     */
    public function getMovieComments(int $movie_id): ?Collection
    {
        $comments = Comment::whereMovieId($movie_id)->orderBy('id', 'desc')->get();
        return $comments;
    }


    /**
     * Fetch Movies from the API and cache the response.
     *
     * @return array
     */
    private function fetchMovies(): Collection
    {
        return Cache::remember('movies', config('maxim.cache_duration'), function () {
            $response = Http::get(config('maxim.base_ap_url') . '/films');
            if ($response->failed()) {
                throw new Exception('Could not fetch movie list, please try again.', 500);
            }

            if ($response->noContent()) {
                throw new Exception('No Content from API', 204);
            }

            return collect($response->object()?->results ?? [])->map(function ($movie) {
                $movie->id = $this->extractIdFromUrl($movie->url);
                return $movie;
            });
        });
    }

    /**
     * Accept a movie url and extract the unique movie id form the url
     *
     * @param string $url
     * @return integer
     */
    private function extractIdFromUrl(string $url): int
    {
        $trimmedUrl = rtrim($url, '/');
        $urlPaths = explode('/', $trimmedUrl);
        return end($urlPaths);
    }
}
