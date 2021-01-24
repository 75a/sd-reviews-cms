<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use HasFactory;
    protected $table = "menu_links";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_name',
        'label',
        'url',
        'zindex'
    ];
}
