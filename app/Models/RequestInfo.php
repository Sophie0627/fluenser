<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestInfo extends Model
{
    use HasFactory;

    protected $table = 'request_info';

    protected $fillable = [
        'request_id',
        'title',
        'content',
        'amount',
        'unit',
        'gift',
        'brand',
        'status',
        'accepted',
        'sr_review',
        'rs_review',
    ];
    /**
     * @var int|mixed
     */

    public function getRequestInfoByID($request_id) {
        $requestInfo = DB::table('request_info')
                ->where('request_id', '=', $request_id)
                ->get();
        $images = DB::table('request_images')
                ->where('request_id', $request_id)
                ->orderBy('created_at')
                ->get();
        if(count($images) > 0)
            $requestInfo[0]->images = $images;
        else $requestInfo[0]->images = 'none';
        return $requestInfo[0];
    }
}
