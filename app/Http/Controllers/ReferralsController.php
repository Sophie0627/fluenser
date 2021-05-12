<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\User;
use Session;
class ReferralsController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $email = Auth::user()->email;
        $ref_link = env('APP_URL') . '/referral/' . hash('sha512', $email);

        $allReferrals = Referral::where('user_id', Auth::user()->id)->get();
        $referralModel = new Referral();
        $referrals = [];
        foreach ($allReferrals as $referral) {
            $influencerInfo = $referralModel->getReferralInfos($referral->referral_user_id);
            if($influencerInfo) {
                $referral->influencerInfo = $influencerInfo;
                array_push($referrals, $referral);
            }
        }

        $count = count($referrals);
        $earned = 0;
        foreach ($referrals as $referral) {
            $earned += $referral->influencerInfo->earned;
        }

        return view('referrals', [
            'count' => $count,
            'earned' => $earned / 10,
            'referrals' => $referrals,
            'ref_link' => $ref_link,
            'unread'=> $request->get('unread'),
        ]);
    }

    public function newUser($ref_link) {
        session(['status' => $ref_link]);
        return redirect('register');;
    }
}