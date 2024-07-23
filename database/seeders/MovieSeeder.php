<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
              "title" => "Workout Paradox",
              "image_url" => "storage/img/workout-paradox.jpg",
              "video_url" =>
                "https://www.youtube.com/embed/lPrjP4A_X4s?si=kRAV4OddwvMD5d7g",
            ],
            [
              "title" => "The Biggest Eruptions That Changed Earth Forever",
              "image_url" => "storage/img/supervolcano.jpg",
              "video_url" => "https://youtu.be/fXb02MQ78yQ?si=tKk1aJYW0xW9jtLs",
            ],
            [
              "title" => "The Disease is Deadlier Than The Plague",
              "image_url" => "storage/img/white-death.jpg",
              "video_url" => "https://youtu.be/GFLb5h2O2Ww?si=_K2vwWz7VstB4nPW",
            ],
            [
              "title" => "There are Thousands of Alien Empires in The Milky Way",
              "image_url" => "storage/img/aliens-everywhere.jpg",
              "video_url" => "https://youtu.be/L_JQOH1tEEA?si=RTydNl8BWvMkJt-2",
            ],
            [
              "title" => "Smoking is Awesome",
              "image_url" => "storage/img/smoking.jpg",
              "video_url" => "https://youtu.be/_rBPwu2uS-w?si=ZXSu-XKJ5aFDAq27",
            ],
            [
              "title" => "The Paradox of an Infinite Universe",
              "image_url" => "storage/img/beyond-the-edge.jpg",
              "video_url" => "https://youtu.be/isdLel273rQ?si=q9hhPLxudrsiK_Dn",
            ],
            [
              "title" => "Did The Future Already Happen?",
              "image_url" => "storage/img/how-time-works.jpg",
              "video_url" => "https://youtu.be/wwSzpaTHyS8?si=jYoG_eu7HykSO_QT",
            ],
            [
              "title" => "The Last Thing to Ever Happen in The Universe",
              "image_url" => "storage/img/the-last-thing.jpg",
              "video_url" => "https://youtu.be/FgnjdW-x7mQ?si=mJ6e7_PKaqZSFn-S",
            ],
            [
              "title" => "How The Dinosaurs Actually Died",
              "image_url" => "storage/img/not-like-this.jpg",
              "video_url" => "https://youtu.be/pjoQdz0nxf4?si=_pF9qvruKrxoscPj",
            ],
          ];

          foreach ($movies as $movie) {

            Movie::create($movie);
          }

          $this->command->info("Movies seeded!");
    }
}
