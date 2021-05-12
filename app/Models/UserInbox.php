<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInbox extends Model
{
    use HasFactory;

    protected $table = 'inbox_user';

    protected $fillable = [
        'inbox_id',
        'user_id',
        'isRead'
    ];
}
