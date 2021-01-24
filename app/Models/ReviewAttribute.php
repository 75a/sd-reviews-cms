<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewAttribute extends Model
{
    use HasFactory;
    protected $table = "review_attributes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'is_nullable'
    ];

    public function reviews()
    {
        return $this->belongsToMany(Review::class);
    }
}
