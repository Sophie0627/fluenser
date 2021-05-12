<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referral';

    protected $fillable = [
        'user_id', 'referral_user_id'
    ];

    public function getReferralInfos ($user_id) {
        $influencer = DB::table('influencers')->where('user_id', '=', $user_id)->get();
        if(count($influencer) > 0) {
            $influencerInfo = DB::table("influencers_info")
                    ->where('influencer_id', '=', $influencer[0]->id)
                    ->select('avatar')
                    ->get();
            $user = User::find($user_id);
            $influencerInfo[0]->name = $user->name;

            $requests = DB::table('requests')
                    ->join('request_info', 'requests.id', '=', 'request_info.request_id')
                    ->where('requests.receive_id', '=', $user_id)
                    ->where('request_info.status', '=', 3)
                    ->get();
            $influencerInfo[0]->paidCount = count($requests);
            $influencerInfo[0]->giftedCount = 0;
            $influencerEarned = 0;
            foreach ($requests as $request) {
                $influencerEarned += $request->amount;
            }
            $influencerInfo[0]->earned = $influencerEarned;
            return $influencerInfo[0];
        } else {
            return false;
        }
    }
}
