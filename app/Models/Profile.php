<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $fillable = [
        'user_Id', 'introduction', 'top_img', 'round_img',
    ];

    public function getPortfolios($user_id) {
        $profile = DB::table('profile')->where('user_id', '=', $user_id)->get();
        $portfolios = DB::table('portfolio')->where('profile_id', '=', $profile[0]->id)->get();

        return $portfolios;
    }
}