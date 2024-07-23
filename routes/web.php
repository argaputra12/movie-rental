<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('welcome');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(["prefix" => "admin", "middleware" => "admin"], function () {
  Route::get("/", "App\Http\Controllers\AdminController@index")->name("admin.index");
  Route::get("/create", "App\Http\Controllers\AdminController@create")->name("admin.create");
  Route::get("/edit", "App\Http\Controllers\AdminController@edit")->name("admin.edit");
  Route::post("/store", "App\Http\Controllers\AdminController@store")->name("admin.store");
  Route::put("users/{id}", "App\Http\Controllers\AdminController@update")->name("admin.update");
  Route::delete("users/{id}", "App\Http\Controllers\AdminController@destroy")->name("admin.destroy");

  Route::prefix("movies")->group(function () {
    Route::get("/", "App\Http\Controllers\MovieController@index")->name("admin.movies.index");
    Route::get("/create", "App\Http\Controllers\MovieController@create")->name("admin.movies.create");
    Route::get("/edit", "App\Http\Controllers\MovieController@edit")->name("admin.movies.edit");
    Route::post("/store", "App\Http\Controllers\MovieController@store")->name("admin.movies.store");
    Route::put("/update", "App\Http\Controllers\MovieController@update")->name("admin.movies.update");
    Route::delete("/delete/{id}", "App\Http\Controllers\MovieController@destroy")->name("admin.movies.destroy");

    Route::get("edit-approval/{id}", "App\Http\Controllers\UserMovieController@editApproval")->name("admin.movies.edit-approval");
    Route::post("update-approval/{id}", "App\Http\Controllers\UserMovieController@updateApproval")->name("admin.movies.update-approval");
  });

  Route::prefix("users")->group(function () {
    Route::get("/", "App\Http\Controllers\UserController@index")->name("admin.users.index");
    Route::get("/create", "App\Http\Controllers\UserController@create")->name("admin.users.create");
    Route::get("/edit", "App\Http\Controllers\UserController@edit")->name("admin.users.edit");
    Route::post("/store", "App\Http\Controllers\UserController@store")->name("admin.users.store");
    Route::put("/update", "App\Http\Controllers\UserController@update")->name("admin.users.update");
    Route::delete("/delete/{id}", "App\Http\Controllers\UserController@destroy")->name("admin.users.destroy");
  });
});

Route::prefix("movies")->group(function () {
  Route::post("/request-access/{id}", "App\Http\Controllers\UserMovieController@request")->name("admin.movies.request-access");
  Route::get("/watch/{id}", "App\Http\Controllers\UserMovieController@index")->name("admin.movies.watch");
  Route::put("update-duration/{id}", "App\Http\Controllers\UserMovieController@updateDuration")->name("admin.movies.update-duration");
});

require __DIR__ . '/auth.php';
