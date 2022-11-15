<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ChildController;
use App\Http\Controllers\API\PersonToContactController;
use App\Http\Controllers\API\DaySummaryController;
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

Route::controller(ChildController::class)->group(function () {
    Route::patch('childUpdateImage/{child}', 'childUpdateImage');
    Route::get('childIndexAuth/{user}', 'childIndexAuth');
    Route::get('childLastDaySummary/{child}', 'childLastDaySummary');
    Route::get('childShowUser/{child}', 'childShowUser');


    Route::post('childs', 'store');
    Route::get('childs', 'index');
    Route::get('childs/{child}', 'show');
    Route::patch('childs/{child}', 'update');
    Route::delete('childs/{child}', 'destroy');
});

Route::controller(DaySummaryController::class)->group(function () {
    Route::get('daysummaryindexChild/{child}', 'SummaryindexChild');
    Route::post('daysummary', 'store');
    Route::get('daysummary', 'index');
    Route::get('daysummary/{daysummary}', 'show');
    Route::patch('daysummary/{daysummary}', 'update');
    Route::delete('daysummary/{daysummary}', 'destroy');
});

Route::controller(PictureController::class)->group(function () {
    Route::get('picturesIndexChild/{child}', 'PictureindexChild');
    Route::post('pictures', 'store');
    // Route::get('daysummary', 'index');
    // Route::get('daysummary/{daysummary}', 'show');
    // Route::patch('daysummary/{daysummary}', 'update');
    Route::delete('pictures/{picture}', 'destroy');
});

// Route::controller(UserController::class)->group(function () {
//     Route::get('users', 'index');
//     Route::post('user', 'store');
//     Route::get('user/{id}', 'show');
//     Route::put('user/{id}', 'update');
//     Route::delete('user/{id}', 'destroy');
// });

// Route::controller(ChildController::class)->group(function () {
//     Route::put('childs/{id}', 'updateImage');
// });

// Route::apiResource("pictures", PictureController::class);

// Route::apiResource("daysummary", DaySummaryController::class);

Route::apiResource("users", UserController::class);

Route::apiResource("persontocontact", PersonToContactController::class);

Route::apiResource("typefiles", TypeFileController::class);

Route::apiResource("files", FileController::class);

Route::apiResource("contacts", ContactController::class);

