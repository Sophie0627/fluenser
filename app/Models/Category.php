<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    public function getCategories($influencer_id) {
        $categories = DB::table('category_influencer')
            ->where('influencer_id', '=', $influencer_id)
            ->join('categories', 'category_influencer.category_id', '=', 'categories.id')
            ->limit(2)
            ->get();

        return $categories;
    }

    public function getBrandCategories($brand_id) {
        $categories = DB::table('category_brand')
            ->where('brand_id', '=', $brand_id)
            ->join('categories', 'category_brand.category_id', '=', 'categories.id')
            ->limit(2)
            ->get();

        return $categories;
    }
}
