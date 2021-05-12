<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saved extends Model
{
    use HasFactory;

    protected $table = 'saved';

    protected $fillable = [
        'user1_id',
        'user2_id',
    ];
}
