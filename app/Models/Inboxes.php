<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inboxes extends Model
{
    use HasFactory;

    protected $table = 'inboxes';

    protected $fillable = [
        'user1_id',
        'user2_id',
    ];

    public function checkInbox($user1_id, $user2_id) {
        $inbox = DB::table('inboxes')
                ->where('user1_id', '=', $user1_id)
                ->where('user2_id', '=', $user2_id)
                ->get();

        if(count($inbox) == 0) {
            $inbox = DB::table('inboxes')
            ->where('user2_id', '=', $user1_id)
            ->where('user1_id', '=', $user2_id)
            ->get();
        }

        if(count($inbox) == 0) {
            $inbox = new Inboxes;
            $inbox->user1_id = $user1_id;
            $inbox->user2_id = $user2_id;
            $inbox->save();
        } else {
            $inbox = $inbox[0];
        }

        return $inbox;
    }
}
