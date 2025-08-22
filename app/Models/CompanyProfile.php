<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'main_services',
        'image',
    ];
}