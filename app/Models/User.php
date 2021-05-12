<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'stripe_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAccountInfoByUserID($user_id) {
        $accountInfo = DB::table('users')
                    ->where('users.id', $user_id)
                    ->join('influencers', 'users.id', '=', 'influencers.user_id')
                    ->join('influencers_info', 'influencers.id','=','influencers_info.influencer_id')
                    ->select('influencers_info.*', 'users.id' ,'users.name', 'users.email', 'users.username', 'users.loggedIn', 'users.updated_at',)
                    ->get();
        if(count($accountInfo) == 0){
            $accountInfo = DB::table('users')
                    ->where('users.id', $user_id)
                    ->join('brands', 'users.id', '=', 'brands.user_id')
                    ->join('brand_info', 'brands.id','=','brand_info.brand_id')
                    ->select('brand_info.*', 'users.id', 'users.name', 'users.email', 'users.username', 'users.loggedIn', 'users.updated_at')
                    ->get();
            if(count($accountInfo) ==0){
                return "none";
            } else {
                $accountInfo[0]->accountType = 'brand';
            }
        } else {
            $accountInfo[0]->accountType = 'influencer';
        }
        $accountInfo[0]->user_id = $user_id;
        // echo $accountInfo[0]->accountType;
        return $accountInfo;
    }

    public function checkIfInfluencer($user_id) {
        $influencer = DB::table('influencers')
                ->where('user_id', $user_id)
                ->get();
        if(count($influencer) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCategory($user_id, $categories) {
        $influencer = DB::table('influencers')
        ->where('user_id', $user_id)
        ->get();
        if(count($influencer) > 0) {
            $influencer_id = $influencer[0]->id;
            $cats = DB::table('category_influencer')
                    ->where('influencer_id', '=', $influencer_id)
                    ->delete();
            foreach ($categories as $category) {
                DB::table('category_influencer')
                        ->insert([
                            'influencer_id' => $influencer_id,
                            'category_id' => $category
                        ]);
            }
            return true;
        } else {
            $brand = DB::table('brands')
                    ->where('user_id', $user_id)
                    ->get();
            $brand_id = $brand[0]->id;
            $cats = DB::table('category_brand')
                    ->where('brand_id', '=', $brand_id)
                    ->delete();
            foreach ($categories as $category) {
                DB::table('category_brand')
                        ->insert([
                            'brand_id' => $brand_id,
                            'category_id' => $category
                        ]);
            }
            return true;

        }
    }
}
