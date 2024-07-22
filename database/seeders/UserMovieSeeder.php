<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use App\Models\UserMovie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create user movie with waiting status

        $users = User::all();
        $movies = Movie::all();

        if ($users->isEmpty() || $movies->isEmpty()) {
            $this->command->info("No users or movies found to seed.");
            return;
        }

        // create user movie without using factory with waiting status except for admin
        foreach ($users as $user) {
          if ($user->is_admin == false) {
                foreach ($movies as $movie) {
                    UserMovie::create([
                        'user_id' => $user->id,
                        'movie_id' => $movie->id,
                        'status' => 'waiting',
                    ]);

                    // Debug output
                    $this->command->info("Seeding user movie: user_id={$user->id}, movie_id={$movie->id}, status=waiting");
                }
            }
        }

    }
}