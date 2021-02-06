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

//todos
Route::apiResource('/todo', 'App\Http\Controllers\API\todoController')->middleware('auth:api');
Route::get('/userTodos', 'App\Http\Controllers\API\todoController@getTodosUser')->middleware('auth:api');

//coments
Route::get('/projects', 'App\Http\Controllers\API\ProjectsController@getProjects');
Route::apiResource('/comment', 'App\Http\Controllers\API\CommentController')->middleware('auth:api');
Route::get('/projectComments/{id}', 'App\Http\Controllers\API\CommentController@getCommentsProject')->middleware('auth:api');;

//form questions
Route::apiResource('/form_question', 'App\Http\Controllers\API\formQuestionController')->middleware('auth:api');
Route::post('/form_question/copy/{id}', 'App\Http\Controllers\API\formQuestionController@copi')->middleware('auth:api');
Route::get('/form_question/getForm/{id}', 'App\Http\Controllers\API\formQuestionController@getForm')->middleware('auth:api');
Route::post('/form_question/saveForm', 'App\Http\Controllers\API\formQuestionController@saveForm')->middleware('auth:api');
Route::get('/form_question/getFormByKey/{form_key}', 'App\Http\Controllers\API\formQuestionController@getFormByKey');

//form responses
Route::delete('/form_response/delete/{id}', 'App\Http\Controllers\API\formResponseController@deleteForm')->middleware('auth:api');
Route::post('/form_response/sendForm', 'App\Http\Controllers\API\formResponseController@saveFormResponse');
Route::get('/form_response/uncheckeresponses', 'App\Http\Controllers\API\formResponseController@getUnchecked')->middleware('auth:api');
Route::get('/form_response/respondedForms', 'App\Http\Controllers\API\formResponseController@getRespondedForms')->middleware('auth:api');
Route::get('/form_response/getForm/{id}', 'App\Http\Controllers\API\formResponseController@getForm')->middleware('auth:api');
Route::put('/form_response/checkForm/{id}', 'App\Http\Controllers\API\formResponseController@checkedForm')->middleware('auth:api');
