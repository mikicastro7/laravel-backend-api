<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:Api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'App\Http\Controllers\API\AuthController@register');
Route::post('/login', 'App\Http\Controllers\API\AuthController@login');

Route::apiResource('/todo', 'App\Http\Controllers\API\todoController')->middleware('auth:api');
Route::get('/userTodos', 'App\Http\Controllers\API\todoController@getTodosUser')->middleware('auth:api');
Route::get('/projects', 'App\Http\Controllers\API\ProjectsController@getProjects');
Route::apiResource('/comment', 'App\Http\Controllers\API\CommentController')->middleware('auth:api');
Route::get('/projectComments/{id}', 'App\Http\Controllers\API\CommentController@getCommentsProject')->middleware('auth:api');;