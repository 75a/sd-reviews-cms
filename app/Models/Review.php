<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = "reviews";

    protected $fillable = [
        'header',
        'main_content',
        'rating',
        'is_published'
    ];

    public function reviewAttributes()
    {
        return $this->belongsToMany(ReviewAttribute::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
