<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "image_url",
        "video_url"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
