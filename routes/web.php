<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PredictionsController;
use App\Http\Controllers\StandingsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// We don't have a homepage - send them home
Route::get('/', function () {
    return redirect('home');
});

// Fixtures
Route::get('fixtures', [FixtureController::class, 'currentFixtures'])->name('fixtures');

// Standings
Route::get('standings', [StandingsController::class, 'index'])->name('standings');

// Predictions

// Home
Route::get('predictions/status', [PredictionsController::class, 'index'])->name('predictions');

// Submit
Route::get('predictions/submit/{userId?}', [PredictionsController::class, 'submit'])
    ->name('submit_predictions')
    ->middleware(['auth']);

// Process Submit
Route::post('predictions/submit/{userId?}', [PredictionsController::class, 'postSubmit'])
    ->middleware(['auth']);

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('testEmail', [TestController::class, 'testEmail']);
