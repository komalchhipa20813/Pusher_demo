<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{ DashboardController,NotificationController};
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

// Route::get('/', function () {
//     return view('welcome');
// });
require __DIR__ . '/auth.php';


Route::group(['middleware' => 'auth'], function () {

    // Route::get('/', function () {
    //     return view('dashboard');
    // })->middleware(['auth'])->name('dashboard');

    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth']);

    Route::get('/chart', function () {
        return view('chart');
    })->middleware(['auth']);

    Route::resources([
        'notification'=>NotificationController::class,
        
    ]);

 

    /* employee */
    Route::group(['prefix' => 'notification'], function () {
        Route::post('/listing', [NotificationController::class, 'listing']);
        // Route::post('/email-check', [EmployeeController::class, 'email_check']);
        // Route::post('/delete-all', [EmployeeController::class, 'deleteAll']);
        // Route::post('/reset-password', [EmployeeController::class, 'reset_password']);
    });

    

});
