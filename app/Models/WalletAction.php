<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WalletAction extends Model
{
    use HasFactory;

    protected $table = 'wallet_action';

    protected $fillable = [
        'wallet_id',
        'amount',
        'action',
        'currency',
        'aaa',
    ];

}
