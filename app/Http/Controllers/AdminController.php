<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Influencers;
use App\Models\InfluencerInfo;
use App\Models\Brands;
use App\Models\BrandInfo;
use App\Models\Requests;
use App\Models\RequestInfo;
use App\Models\Referral;
use App\Models\Profile;

class AdminController extends Controller
{
  public function index() {
    $users = User::all();
    $influencers = Influencers::all();
    $brands = Brands::all();
    $giftedRequests = RequestInfo::where('gift', '=', 1)->get();
    $paidRequests = RequestInfo::where('gift', '=', 0)->get();
    $gifted = floor(count($giftedRequests) / (count($giftedRequests) + count($paidRequests)) * 100);
    $paid = 100 - $gifted;
    $referrals =Referral::orderBy('created_at', 'desc')->limit(3)->get();
    foreach ($referrals as $referral) {
      $user = new User();
      $influencerInfo = $user->getAccountInfoByUserID($referral->user_id);
      $referral_userInfo = $user->getAccountInfoByUserID($referral->referral_user_id);
      $referral->influencerInfo = $influencerInfo[0];
      $referral->influencerProfile = Profile::where('user_id', '=', $referral->user_id)->first();
      $referral->referral_userInfo = $referral_userInfo[0];
      $referral->influencerProfile = Profile::where('user_id', '=', $referral->referral_user_id)->first();
    }

    return view('admin.dashboard', [
      'user_count' => count($users),
      'influencer_count' => count($influencers),
      'brand_count' => count($brands),
      'gifted' => $gifted,
      'paid' => $paid ,
      'referrals' => $referrals,
      'page' => 1
    ]);
  }

  public function news() {
    return view('admin.news', [
      'page' => 3,
    ]);
  }

  public function users(Request $request) {
    $input = $request->all();
    $name = (isset($input['name'])) ? $input['name'] : '';
    $categories = (isset($input['categories'])) ? $input['categories'] : [];
    $location = (isset($input['location'])) ? $input['location'] : '';
    $accountType = (isset($input['accountType'])) ? $input['accountType'] : 'influencer';
    $keyword = (isset($input['keyword'])) ? $input['keyword'] : '';
    $perpage = (isset($input['perpage']))? $input['perpage'] : 10;

    if($name == '' && count($categories) == 0 && $location == '' && $keyword == '') {
      return view('admin.search', [
        'page' => 2,
      ]);
    }

    $users = new User();
    $results = $users->getUsers($name, $categories, $location, $keyword, $accountType, $perpage);
    return view('admin.search', [
      'users' => $results,
      'page' => 2,
    ]);
  }

  public function projects(Request $request) {
    $input = $request->all();
    $keyword = (isset($input['keyword'])) ? $input['keyword'] : '';
    $requests = new Requests();
    $projects = $requests->getAllRequests($keyword);

    return view('admin.projects', [
      'page' => 4,
      'projects' => $projects,
      'keyword' => $keyword,
    ]);
  }
}
