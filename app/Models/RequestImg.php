<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestImg extends Model
{
    use HasFactory;

    protected $table = 'request_images';

    protected $fillable = [
        'request_id',
        'image',
    ];
}
