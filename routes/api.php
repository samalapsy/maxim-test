<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\AddMovieCommentController;
use App\Http\Controllers\Api\GetMovieCommentsController;
use App\Http\Controllers\Api\GetMovieCharactersController;


Route::get('movies', MoviesController::class);
Route::middleware('movie-exist')->group(function () {
    Route::get('movies/{movie_id}/characters', GetMovieCharactersController::class);
    Route::get('movies/{movie_id}/comments', GetMovieCommentsController::class);
    Route::post('movies/{movie_id}/comments', AddMovieCommentController::class)->middleware('throttle:movie-comment');
});
