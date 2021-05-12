<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Influencers;
use App\Models\InfluencerInfo;
use App\Models\Brands;
use App\Models\BrandInfo;
use App\Models\Profile;
use App\Models\Wallet;
use App\Models\WalletUser;
use App\Models\Referral;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'full_name.required' => 'Please enter your first name!',
            'username.required' => 'Please enter your last name!',
            'username.unique' => 'Username already exits',
            'email.required' => 'Please enter your email!',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Retype your password!',
            'agreement.required' => 'Do you agree with our terms and conditions?',
            'full_name.regex' => 'Only letters and space are allowed.',
            'usernmae.regex' => 'Only letters and numbers are allowed',
        ];

        return Validator::make($data, [
            'full_name' => ['required', 'string', 'max:255', 'regex:/(^([a-zA-Z ]+)?$)/'],
            'username' => ['required', 'string', 'max:255', 'unique:users' ,'regex:/(^([a-zA-Z0-9]+)?$)/'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agreement' => ['required'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $status = session('status', 'default');

        $token = Str::random(60);
        $user = new User;
        $user->name = $data['full_name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->api_token = hash('sha256', $token);
        $user->username = $data['username'];
        $user->loggedIn = true;
        $user->stripe_id = '';
        $user->save();

        $accountType = (isset($data['accountType'])) ? $data['accountType'] : 'influencer';

        if($user->id != NULL) {
            if($accountType == 'influencer'){
                $influencer = new Influencers;
                $influencer->user_id = $user->id;
                $influencer->save();

                $influencerInfo = new InfluencerInfo;
                $influencerInfo->influencer_id = $influencer->id;
                $influencerInfo->save();
            }
            else {
                $brand = new Brands;
                $brand->user_id = $user->id;
                $brand->save();

                $brandInfo = new BrandInfo;
                $brandInfo->brand_id = $brand->id;
                $brandInfo->save();
            }
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->introduction = "Hi, please complete your profile!";
            $profile->top_img = "default_top";
            $profile->round_img = "default_round";
            $profile->instagram = "";
            $profile->instagram_follows = "";
            $profile->youtube = '';
            $profile->youtube_follows = '';
            $profile->tiktok = '';
            $profile->tiktok_follows = '';
            $profile->save();

            $wallet = new Wallet;
            $wallet->usd_balance = 0;
            $wallet->gbp_balance = 0;
            $wallet->eur_balance = 0;
            $wallet->save();

            $walletUser = new WalletUser;
            $walletUser->user_id = $user->id;
            $walletUser->wallet_id = $wallet->id;
            $walletUser->save();

            if($status != 'default') {
                $users = User::all();
                foreach ($users as $ref_user) {
                    $ref = hash('sha512', $ref_user->email);
                    if($ref == $status) {
                        $referral = Referral::where('user_id', '=', $ref_user->id)
                                ->where('referral_user_id', '=', $user->id)
                                ->get();
                        if(count($referral) < 1) {
                            $new_ref = new Referral;
                            $new_ref->user_id = $ref_user->id;
                            $new_ref->referral_user_id = $user->id;
                            $new_ref->save();
                        }
                    }
                }
            }

            return $user;
        }
    }
}
