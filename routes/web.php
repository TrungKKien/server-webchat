<?php


use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('{page}', 'App\Http\Controllers\LayoutsController@Get'. $page);
// Route::get('login', 'App\Http\Controllers\LayoutsController@Getlogin');

// Route::get('{page}', [LayoutsController::class, 'Get{page}']);

// Route::get('login', [LayoutsController::class, "Getlogin"]);


// Route::get('/', function () {
//     return view('welcome');
// });
