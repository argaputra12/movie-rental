<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::orderBy("created_at", "desc")->paginate(10);

    $loginUser = Auth::check() ? Auth::user() : null;

    return Inertia::render("Admin/Users/Index", [
      "users" => $users,
      "canLogin" => $loginUser,
      "canRegister" => $loginUser,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

    return Inertia::render("Admin/Users/Create", [
      "canLogin" => Auth::check() ? Auth::user() : null,
      "canRegister" => Auth::check() ? Auth::user() : null,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      "name" => "required|string",
      "email" => "required|email",
      "password" => "required|string",
    ]);

    User::create($validated);

    return response()->json(["success" => "User created successfully"]);
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
    User::destroy($id);

    return response()->json(["success" => "User deleted successfully"]);
  }
}
