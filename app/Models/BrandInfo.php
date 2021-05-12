<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandInfo extends Model
{
    use HasFactory;

    protected $table = "brand_info";

    protected $fillable = [
        'country',
        'state',
        'avatar',
        'back-img'
    ];
}
