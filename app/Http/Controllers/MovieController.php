<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserMovie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $movies = Movie::orderBy("created_at", "desc")->paginate(10);

    $loginUser = Auth::check() ? Auth::user() : null;

    return Inertia::render("Admin/Movies/Index", [
      "movies" => $movies,
      "canLogin" => $loginUser,
      "canRegister" => $loginUser,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render("Admin/Movies/Create", [
      "canLogin" => Auth::check() ? Auth::user() : null,
      "canRegister" => Auth::check() ? Auth::user() : null,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'video_url' => 'required|url',
    ]);

    $fileName = 'storage/img/' . time() . '.' . $request->file->getClientOriginalExtension();

    // Store the uploaded file
    if ($request->hasFile('file')) {
      $fileName = time() . '.' . $request->file('file')->getClientOriginalExtension();
      $filePath = $request->file('file')->storeAs('img', $fileName, 'public');
      $imageUrl = Storage::url($filePath);
    } else {
      return response()->json(["error" => "Image not found"], 400);
    }

    Movie::create([
      'title' => $request->title,
      'video_url' => $request->video_url,
      'image_url' => $imageUrl,
    ]);

    return response()->json(["success" => "Movie created successfully"]);
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
    Movie::destroy($id);

    return response()->json(["success" => "Movie deleted successfully"]);
  }

  /**
   * Request approval for a movie
   */
  public function request(Request $request){
    $request->validate([
      'movie_id' => 'required|integer',
    ]);

    $movie = Movie::find($request->movie_id);

    if(!$movie){
      return response()->json(["error" => "Movie not found"], 404);
    }

    $user = Auth::user();

    $userMovies = UserMovie::create([
      'user_id' => $user->id,
      'movie_id' => $movie->id,
      'status' => 'waiting',
    ]);

    if(!$userMovies){
      return response()->json(["error" => "Movie request failed"], 400);
    }

    return response()->json(["success" => "Movie request sent successfully"]);
  }


}
