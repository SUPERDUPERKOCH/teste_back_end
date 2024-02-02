<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'Api',
    'prefix' => 'v1'
], function () {
    

    Route::group([
        'middleware' => ['api' ],
        // 'middleware' => ['api']
    ], function () {
        Route::get('/redirects/{encoded_id}/stats', [RedirectController::class, 'stats']);
        Route::get('/redirects', [RedirectController::class, 'show']);
        Route::get('/redirects/add', [RedirectController::class, 'add']);
        Route::post('/redirects/add', [RedirectController::class, 'create']);
        Route::get('/redirects/edit/{encoded_id}', [RedirectController::class, 'edit']);
        Route::put('/redirects/{encoded_id}', [RedirectController::class, 'update']);
        Route::delete('/redirects/delete/{encoded_id}', [RedirectController::class, 'delete']);

    });

});