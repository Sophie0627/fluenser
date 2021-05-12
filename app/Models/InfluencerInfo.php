<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InfluencerInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'state',
        'follows',
        'followings',
        'posts',
        'avatar',
        'back-img',
        'arg_rate',
        'bf_rate',
        'tm_rate',
        'm_rate',
    ];

    protected $table = 'influencers_info';

    public function getFeaturedInfluencers() {
        $influencers = DB::table('influencers_info')
                ->join('influencers', 'influencers_info.influencer_id', '=', 'influencers.id')
                ->join('users', 'users.id', '=', 'influencers.user_id')
                ->join('profile', 'profile.user_id', '=', 'users.id')
                ->orderBy('rating', 'desc')
                ->orderBy('reviews', 'desc')
                ->limit(4)
                ->select('users.name',
                        'users.username',
                        'influencers_info.country',
                        'influencers_info.state',
                        'influencers_info.rating',
                        'profile.top_img')
                ->get();

        return $influencers;
    }
}
