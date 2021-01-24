<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;
    protected $table = "widgets";

    protected $fillable = [
        'header',
        'main_content',
        'is_published',
        'position'
    ];
}
