<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeChat extends Model
{
    use HasFactory;

    protected $table = 'dispute_chat';

    protected $fillable = [
        'request_id',
        'send_id',
        'receive_id',
        'content',
        'upload',
        'status'
    ];
}
