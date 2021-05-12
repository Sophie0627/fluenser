<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = 'user_request';

    protected $fillable = [
        'request_id',
        'user_id',
        'isRead'
    ];
}
