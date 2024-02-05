<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RegistrationController;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/logout', [LogoutController::class, 'index'])->name('logout');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegistrationController::class, 'index'])->name('register');
Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/tasks', [TasksController::class, 'index'])->name('tasks');
Route::post('/tasks', [TasksController::class, 'store']);
Route::post('/tasks/{tasks}', [TasksController::class, 'update'])->name('tasks.update');
Route::post('/tasks/{tasks}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
Route::post('/tasks/{tasks}/assign', [TasksController::class, 'assign'])->name('tasks.assign');
Route::post('/tasks/{tasks}/taskDone', [TasksController::class, 'taskDone'])->name('tasks.done');
Route::delete('/tasks/{tasks}/task', [TasksController::class, 'destroy'])->name('tasks.delete');

Route::post('/tasks/{tasks}/comment', [CommentController::class, 'store'])->name('tasks.comment');
Route::delete('/tasks/{comment}/comment', [CommentController::class, 'destroy'])->name('comment.delete');

Route::post('/task-assigned', [App\Http\Controllers\TaskAssignedController::class, 'taskAssigned'])->name('taskAssigned');
Route::get('/mark-as-read', [App\Http\Controllers\TasksController::class, 'markAsRead'])->name('markAsRead');
