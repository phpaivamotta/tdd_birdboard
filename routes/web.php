<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectInvitationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // routes from breeze
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Routes I created
    // projects 
    Route::resource('projects', ProjectsController::class);

    Route::post('/projects/{project}/invitations', [ProjectInvitationsController::class, 'store']);

    // tasks
    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store'])
        ->name('projects.tasks.store');

    Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update'])
        ->name('projects.tasks.update');
});


require __DIR__ . '/auth.php';
