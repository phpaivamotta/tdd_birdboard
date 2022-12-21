<?php

use App\Http\Controllers\ProfileController;
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

    // routes I created
    Route::get('/projects', [ProjectsController::class, 'index'])
        ->name('projects.index');

    Route::get('/projects/create', [ProjectsController::class, 'create'])
        ->name('projects.create');

    Route::get('/projects/{project}', [ProjectsController::class, 'show'])
    ->name('projects.show');
    
    Route::post('/projects', [ProjectsController::class, 'store'])
    ->name('projects.store');
        
    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store'])
        ->name('projects.tasks.store');

    Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update'])
        ->name('projects.tasks.update');
});


require __DIR__ . '/auth.php';
