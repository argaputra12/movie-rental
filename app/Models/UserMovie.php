<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMovie extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "movie_id",
        "status",
        "duration"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}