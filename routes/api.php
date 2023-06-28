<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\AddMovieCommentController;
use App\Http\Controllers\ListMovieCommentsController;


Route::get('movies', MoviesController::class);
Route::get('movies/{movie_id}/comments', ListMovieCommentsController::class);
Route::post('movies/{movie_id}/comments', AddMovieCommentController::class)->middleware('throttle:1,20');
