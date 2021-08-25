<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['api','checksecurity', 'changelang'], 'namespace' => 'Api'], function(){
    Route::get('get-categories', [CategoriesController::class, 'index']);
    Route::post('get-category-byid', [CategoriesController::class, 'getCategoryById']);
    Route::patch('get-category-status', [CategoriesController::class, 'changeCategoryStatus']);
});
