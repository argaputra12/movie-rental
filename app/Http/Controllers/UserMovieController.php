<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Movie;
use App\Models\UserMovie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserMovieController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(string $id)
  {
    $userMovie = UserMovie::where("user_id", Auth::id())->where("movie_id", $id)->first();
    return Inertia::render("Movies/Watch", [
      "canLogin" => Auth::check() ? Auth::user() : null,
      "canRegister" => Auth::check() ? Auth::user() : null,
      "movie" => Movie::find($id),
      "userMovie" => $userMovie
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
  public function updateDuration(Request $request, string $id)
  {
    $userMovie = UserMovie::find($id);

    if (!$userMovie) {
      return response()->json(["error" => "User Movie not found"], 404);
    }

    $userMovie->duration = $request->duration;

    // If duration is zero, change status to "waiting"
    if ($userMovie->duration <= 0) {
        $userMovie->status = "waiting";
    }

    $userMovie->save();

    return response()->json(["success" => "Movie updated successfully"]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  /**
   * Request approval for a movie
   */
  public function request(Request $request)
  {
    $request->validate([
      'movie_id' => 'required|integer',
    ]);

    $movie = Movie::find($request->movie_id);

    if (!$movie) {
      return response()->json(["error" => "Movie not found"], 404);
    }

    $user = Auth::user();

    UserMovie::create([
      'user_id' => $user->id,
      'movie_id' => $movie->id,
      'status' => 'waiting',
    ]);

    return response()->json(["success" => "Request sent successfully"]);
  }

  /**
   * Update approval status for a movie
   */
  public function editApproval(string $id)
  {
    // Get the user movie record with user name and movie title
    $userMovie = UserMovie::with("user", "movie")->find($id);
    $userMovie->name = $userMovie->user->name;
    $userMovie->title = $userMovie->movie->title;

    if (!$userMovie) {
      return response()->json(["error" => "Movie not found"], 404);
    }

    return Inertia::render("Admin/Movies/EditApproval", [
      "userMovie" => $userMovie,
      "canLogin" => Auth::check() ? Auth::user() : null,
      "canRegister" => Auth::check() ? Auth::user() : null,
    ]);
  }

  /**
   * Update approval status for a approval
   */
  public function updateApproval(Request $request, string $id)
  {
    $request->validate([
      'status' => 'required',
      'duration' => 'required|integer',
    ]);

    $userMovie = UserMovie::find($id);

    if (!$userMovie) {
      return response()->json(["error" => "User Movie not found"], 404);
    }

    $userMovie->status = $request->status;
    $userMovie->duration = $request->duration * 100;
    $userMovie->save();

    return response()->json(["success" => "Approval status updated successfully"]);
  }
}
