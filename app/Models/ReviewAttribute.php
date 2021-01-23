<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewAttribute extends Model
{
    use HasFactory;
    protected $table = "review_attributes";

    public function reviews()
    {
        return $this->belongsToMany(Review::class);
    }
}
