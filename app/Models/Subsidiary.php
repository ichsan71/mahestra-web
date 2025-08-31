<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    protected $fillable = [
        'title',
        'image',
        'name',
        'description',
        'is_published',
    ];
}
