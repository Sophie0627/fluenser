<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletUser extends Model
{
    use HasFactory;

    protected $table = 'wallet_user';

    protected $fillable = [
        'user_id',
        'wallet_id',
    ];
}
