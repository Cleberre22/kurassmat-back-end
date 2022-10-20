<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ChildController;
use App\Http\Controllers\API\PersonToContactController;
use App\Http\Controllers\API\TypeFileController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\PictureController;
use App\Http\Controllers\API\ContactController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('registerAssmat', 'registerAssmat');
    Route::post('registerEmployer', 'registerEmployer');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('current-user', 'currentUser');
});

// Route::controller(UserController::class)->group(function () {
//     Route::get('users', 'index');
//     Route::post('user', 'store');
//     Route::get('user/{id}', 'show');
//     Route::put('user/{id}', 'update');
//     Route::delete('user/{id}', 'destroy');
// });

Route::apiResource("users", UserController::class);

Route::apiResource("childs", ChildController::class);

Route::apiResource("persontocontact", PersonToContactController::class);

Route::apiResource("typefiles", TypeFileController::class);

Route::apiResource("files", FileController::class);

Route::apiResource("pictures", PictureController::class);

Route::apiResource("contacts", ContactController::class);

//EXEMPLE

// Route::controller(TodoController::class)->group(function () {
//     Route::get('todos', 'index');
//     Route::post('todo', 'store');
//     Route::get('todo/{id}', 'show');
//     Route::put('todo/{id}', 'update');
//     Route::delete('todo/{id}', 'destroy');
// }); 
