<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestChat extends Model
{
    use HasFactory;

    protected $table = 'request_chat';

    protected $fillable = [
        'request_id', 'send_id', 'receive_id', 'content',
    ];

    public function getRequestChatInfo($request_id, $user1_id, $user2_id) {
        $requestChatInfos = DB::table('request_chat')
                ->where('request_id', '=', $request_id)
                ->get();

        return $requestChatInfos;
    }
}