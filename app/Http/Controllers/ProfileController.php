<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Review;
use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\Influencers;
use App\Models\Brands;
use App\Models\InfluencerInfo;
use App\Models\BrandInfo;
use App\Models\Countries;
use App\Models\Saved;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index(Request $request, $username) {
        $userInfo = User::where('username', '=', $username)->get();
        $user_id = $userInfo[0]->id;
        $user = new User();
        $accountInfo = $user->getAccountInfoByUserID($user_id);

        if(! $accountInfo[0]->loggedIn) {
            $updated = date_create($accountInfo[0]->updated_at);
            $now = date_create(date('Y-m-d h:i:sa'));
            $interval = date_diff($updated, $now);
            if($interval->format('%m') > 0)
                $accountInfo[0]->interval = $interval->format('%m month');
            if($interval->format('%m') == 0 && $interval->format('%h') > 0)
                $accountInfo[0]->interval = $interval->format("%h hour");
            if($interval->format('%h') == 0 && $interval->format('%m') == 0 && $interval->format('%i') > 0)
                $accountInfo[0]->interval = $interval->format('%i minutes');
            if($interval->format('%h') == 0 && $interval->format('%m') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $accountInfo[0]->interval = $interval->format('%sa seconds');
        } else {
            $accountInfo[0]->interval = '0';
        }

        // echo $accountInfo;

        if($accountInfo[0]->accountType == 'influencer') {

            $category = new Category();
            $categories = $category->getCategories($accountInfo[0]->influencer_id);

            $partnerships = Partnership::where('influencer_id', $accountInfo[0]->influencer_id)->get();
        } else {
            $category = new Category();
            $categories = $category->getBrandCategories($accountInfo[0]->brand_id);

            $partnerships = [];
        }

        $review = new Review();
        $reviews = $review->getReviewsByUserID($user_id);

        $profile = Profile::where('user_id', $user_id)->get();

        $portfolios = Portfolio::where('profile_id', $profile[0]->id)->get();

        if(isset(Auth::user()->id)) {
            $saved = Saved::where('user1_id', '=', Auth::user()->id)->
                    where('user2_id', '=', $user_id)
                    ->get();
            if(count($saved) == 0) {
                $saved = 0;
            } else {
                $saved =1;
            }
        } else {
            $saved = 0;
        }

        return view('profile', [
            'page' => 4,
            'unread' => $request->get('unread'),
            'accountInfo' => $accountInfo[0],
            'profile' => $profile[0],
            'portfolios' => $portfolios,
            'reviews' => $reviews,
            'categories' => $categories,
            'partnerships' => $partnerships,
            'saved' => $saved,
        ]);
    }

    public function imageUpload(Request $request) {
        $input = $request->all();
        $base64_image = $input['top_img'];

        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $filename = time() . "_" . uniqid();
            $data = base64_decode($data);
            Storage::disk('local')->put($filename.'.png', $data);
            dd("stored");
            return redirect('editProfile')
                ->with('success', 'success')
                ->with('filename', $filename);
        }
    }

    public function saveImage(Request $request) {
        $image = $request['image'];
        $position = $request['position'];

        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $filename = time() . "_" . uniqid();
        $disk = Storage::disk('local');
        switch ($position) {
            case 'top':
                $profile = Profile::where('user_id', '=', Auth::user()->id)->first();
                // delete prev top image
                if($profile->top_img != 'default_top'){
                    $prevFileName = $profile->top_img . '.jpg';
                    Storage::delete('profile-image/'.$prevFileName);
                }
                // save new top image
                $disk->put('/profile-image/'.$filename.'.jpg', file_get_contents($image));
                // update database
                $profile->top_img = $filename;
                $profile->save();
                return response()->json([
                    "file" => $filename
                ]);
                break;

            case 'round':
                $profile = Profile::where('user_id', '=', Auth::user()->id)->get();
                // delete prev round img
                if($profile[0]->round_img != 'default_round') {
                    $prevFileName = $profile[0]->round_img . '.jpg';
                    Storage::delete('profile-image/'.$prevFileName);
                }
                // save new round image
                $disk->put('/profile-image/'.$filename.'.jpg', file_get_contents($image));
                $user = new User();
                $accountInfo = $user->getAccountInfoByUserID(Auth::user()->id);

                if($accountInfo[0]->accountType == 'influencer') {
                    $influencerInfo = InfluencerInfo::where("influencer_id", '=', $accountInfo[0]->influencer_id)->get();
                    $influencerInfo[0]->avatar = $filename;
                    $influencerInfo[0]->save();
                } else {
                    $brandInfo = BrandInfo::where("brand_id", '=', $accountInfo[0]->brand_id)->get();
                    $brandInfo[0]->avatar = $filename;
                    $brandInfo[0]->save();
                }

                // update database
                $profile[0]->round_img = $filename;
                $profile[0]->save();
                return response()->json([
                    "file" => $filename
                ]);
                break;

            case 'portfolio':
                $disk->put('profile-image/'.$filename.'.jpg', file_get_contents($image));

                $profile = Profile::where('user_id', '=', Auth::user()->id)->get();
                $portfolio = new Portfolio;
                $portfolio->profile_id = $profile[0]->id;
                $portfolio->slide_img = $filename;
                $portfolio->save();
                return response()->json([
                    "file" => $filename
                ]);
                break;

            case 'partnership':
                $disk->put('partnership-image/'.$filename.'.jpg', file_get_contents($image));

                $user = new User();
                $accountInfo = $user->getAccountInfoByUserID(Auth::user()->id);
                $partnership = new Partnership;
                $partnership->influencer_id = $accountInfo[0]->influencer_id;
                $partnership->partnership_img = $filename;
                $partnership->save();
                return response()->json([
                    "file" => $filename
                ]);
                break;

            default:
                break;
        }
    }

    public function deleteImage() {
        $filename = $_POST['filename'];
        $position = $_POST['position'];

        switch ($position) {
            case 'portfolio':
                // delete prev file
                $prevFileName = 'profile-image/' . $filename . '.jpg';
                Storage::delete($prevFileName);
                // remove from database
                $profile = Profile::where('user_id', '=', Auth::user()->id)->get();
                $portfolio = Portfolio::where('profile_id', '=', $profile[0]->id)
                    ->where('slide_img', '=', $filename)->get();
                $portfolio[0]->delete();
                return response()->json([
                    'data'=> 'success',
                ]);
                break;

            case 'partnership':
                // delete prev file
                $prevFileName = 'partnership-image/' . $filename . '.jpg';
                Storage::delete($prevFileName);
                // remove from database
                $user = new User();
                $accountInfo = $user->getAccountInfoByUserID(Auth::user()->id);
                $partnership = Partnership::where('influencer_id', '=', $accountInfo[0]->influencer_id)
                        ->where('partnership_img', '=', $filename)
                        ->get();
                $partnership[0]->delete();
                return response()->json([
                    'data'=> 'success'
                ]);
                break;

            default:
                # code...
                break;
        }
    }

    public function editProfile(Request $request, $username) {
        $userInfo = User::where('username', '=', $username)->get();
        $user_id = $userInfo[0]->id;
        $user = new User();
        $accountInfo = $user->getAccountInfoByUserID($user_id);

        $profile = Profile::where('user_id', $user_id)->get();

        $portfolios = Portfolio::where('profile_id', $profile[0]->id)->get();

        $category = new Category();
        if($accountInfo[0]->accountType == 'influencer') {
            $selectedCategories = $category->getCategories($accountInfo[0]->influencer_id);
            $partnerships = Partnership::where('influencer_id', $accountInfo[0]->influencer_id)->get();
        }
        else {
            $selectedCategories = $category->getBrandCategories($accountInfo[0]->brand_id);
            $partnerships = [];
        }
        $categories = Category::all();

        $countries = Countries::all();

        return view('editProfile', [
            'page' => 5,
            'unread' => $request->get('unread'),
            'accountInfo' => $accountInfo[0],
            'countries' => $countries,
            'profile' => $profile[0],
            'portfolios' => $portfolios,
            'selectedCategories' => $selectedCategories,
            'categories' => $categories,
            'partnerships' => $partnerships,
        ]);
    }

    public function updateProfile(Request $request, $user_id) {
        $input = $request->all();

        $rule = [
            'name' => 'required|regex:/(^([a-zA-Z 0-9]+)?$)/',
            'username' => 'required|regex:/(^([a-zA-Z]+)(\d+)?$)/',
            'state' => 'required|regex:/(^([a-zA-Z ]+)?$)/',
            'introduction' => 'required|max:140',
        ];

        $messages = [
            'name.regex' => 'Invalid letters!',
            'username.regex' => 'Invalid letters!',
            'state.regex' => 'Invalid letters!',
            'introduction.max' => 'Max length is 140 letters',
        ];

        $validator = Validator::make($input, $rule, $messages);

        if($validator->fails()) {
            return redirect()->route('editProfile', [
                'username' => Auth::user()->username])
                    ->withErrors($validator)
                    ->withInput($input);
        }

        // update profile
        $profile = Profile::where('user_id', $user_id)->get();
        $profile[0]->introduction = $input['introduction'];

        // // update social links
        if(isset($input['instagram']) && $input['instagram']) {
            if($input['instagram-link'] != '')
                $profile[0]->instagram = $input['instagram-link'];
            if($input['instagram-follow'] != '')
                $profile[0]->instagram_follows = $input['instagram-follow'];
        }
        if(isset($input['youtube']) && $input['youtube']) {
            if($input['youtube-link'] != '')
                $profile[0]->youtube = $input['youtube-link'];
            if($input['youtube-follow'] != '')
                $profile[0]->youtube_follows = $input['youtube-follow'];
        }
        if(isset($input['tiktok']) && $input['tiktok']) {
            if($input['tiktok-link'] != '')
                $profile[0]->tiktok = $input['tiktok-link'];
            if($input['tiktok-follow'] != '')
                $profile[0]->tiktok_follows = $input['tiktok-follow'];
        }
        $profile[0]->save();


        // update user info
        $user = User::find($user_id);
        if($input['name'] != '') $user->name = $input['name'];
        if($input['username'] != '') $user->username = $input['username'];
        $user->save();

        // update account
        $user = new User();
        if($user->checkIfInfluencer($user_id)) {
            $influencer = Influencers::where('user_id', '=', $user_id)->get();
            $influencer_id = $influencer[0]->id;
            $influencerInfo = InfluencerInfo::where('influencer_id', '=', $influencer_id)->get();
            $influencerInfo = $influencerInfo[0];
            if($input['state'] != '') {
                $influencerInfo->state = $input['state'];
            }
            if($input['country'] != '') {
                $country = Countries::find($input['country']);
                $influencerInfo->country = $country->name;
            }
            $influencerInfo->save();
        } else {
            $brand = Brands::where('user_id', '=', $user_id)->get();
            $brand_id = $brand[0]->id;
            $brandInfo = BrandInfo::where('brand_id', '=', $brand_id)->get();
            $brandInfo = $brandInfo[0];
            if($input['state'] != '') {
                $brandInfo->state = $input['state'];
            }
            if($input['country'] != '') {
                $country = Countries::find($input['country']);
                $brandInfo->country = $country->name;
            }
            $brandInfo->save();
        }

        // update category
        $user = new User();
        if(isset($input['category']) && $input['category']) {
            $categories = $input['category'];
            $user->updateCategory($user_id, $categories);
        }

        $user = User::find($user_id);
        return redirect()->route('profile', [
            'username' => $user->username
        ]);
    }

    public function saveToggle($user2_id) {
        $user1_id = Auth::user()->id;
        $saved = Saved::where('user1_id', '=', $user1_id)
                ->where('user2_id', '=', $user2_id)
                ->get();
        if(count($saved) == 0) {
            $newSaved = new Saved;
            $newSaved->user1_id = $user1_id;
            $newSaved->user2_id = $user2_id;
            $newSaved->save();
            $data = 1;
        } else {
            $saved[0]->delete();
            $data = 0;
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function saved(Request $request) {
        $saved_ids = Saved::where('user1_id', '=', Auth::user()->id)->get();

        $savedInfo = [];
        if(count($saved_ids) > 0) {
            foreach ($saved_ids as $user_id) {
                $user = new User();
                $user_info = $user->getAccountInfoByUserID($user_id->user2_id);
                $accountInfo = $user_info[0];

                $profile = Profile::where('user_id', '=', $user_id->user2_id)
                ->select('instagram', 'instagram_follows', 'youtube', 'youtube_follows', 'tiktok', 'tiktok_follows')
                ->get();
                $accountInfo->profile = $profile[0];

                $category = new Category();
                if($accountInfo->accountType == 'influencer') {
                    $categories = $category->getCategories($accountInfo->influencer_id);

                } else {
                    $categories = $category->getBrandCategories($accountInfo->brand_id);
                }
                $accountInfo->categories = $categories;

                array_push($savedInfo, $accountInfo);
            }
        }

        return view('saved', [
            'unread' => $request->get('unread'),
            'savedInfos' => $savedInfo,
        ]);
    }}
