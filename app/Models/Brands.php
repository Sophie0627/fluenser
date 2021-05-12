<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brands extends Model
{
    use HasFactory;

    protected $table = "brands";

    protected $fillable = [
        'user_id',
    ];

    public function findBrands($category, $location, $name, $keyword, $perpage) {
        $brands = DB::table('users')
                ->join('profile', 'profile.user_id', '=', 'users.id')
                ->join('brands', 'brands.user_id', '=', 'profile.user_id')
                ->join('brand_info', 'brands.id', '=', 'brand_info.brand_id');
        
        if($name != "")
            $brands = $brands
                    ->where('users.name', 'LIKE', '%'.$name.'%')
                    ->orwhere('users.username', 'LIKE', '%'.$name.'%');
        
        if($location != "Any")
            $brands = $brands
                    ->where('brand_info.country', '=', $location);

        $brands = $brands->select([
            'users.id',
            'users.name',
            'users.username',
            'profile.instagram_follows',
            'profile.youtube_follows',
            'profile.tiktok_follows',
            'brand_info.brand_id',
            'brand_info.country',
            'brand_info.state',
            'brand_info.posts',
            'brand_info.avatar',
            'brand_info.back_img',
            'brand_info.reviews',
            'brand_info.rating',
        ])->get();

        $foundBrands = [];
        $count = 0;
        for ($i=0; $i < count($brands); $i++) { 
            $brand = $brands[$i];
            $foundCategories = DB::table('category_brand')
                    ->where('category_brand.brand_id', '=', $brand->brand_id)
                    ->join('categories', 'category_brand.category_id', '=', 'categories.id');
            if($category != 'Any') {
                $foundCategories = $foundCategories->get();
                $containCount = 0;
                foreach ($foundCategories as $foundCategory) {
                    if($category == $foundCategory->category_name)
                        $containCount ++;
                }
                if($containCount == 1) {
                    $brand->category = $foundCategories;
                    $foundBrands[$count] = $brand;
                    $count ++;
                }
            } else {
                $foundCategories = $foundCategories->get();
                $brand->category = $foundCategories;
                $foundBrands[$i] = $brand;
            }
        }

        if($name == "" && $category == "Any" && $location == "Any" && $keyword == "")
            $foundBrands = [];
        
        return $foundBrands;
    }
}