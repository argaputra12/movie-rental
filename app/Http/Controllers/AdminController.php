<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\UserMovie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      // get user movies with user name and movie title
      $userMovies = UserMovie::with("user", "movie")->paginate(10);

      $user = Auth::check() ? Auth::user() : null;

        return Inertia::render("Admin/Index", [
            "userMovies" => $userMovies,
            "canLogin" => $user,
            "canRegister" => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}