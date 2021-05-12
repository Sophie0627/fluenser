<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Requests extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'send_id',
        'receive_id',
    ];

    public function getInfluencerTasksByID($user_id) {
        $tasks = DB::table('requests')
                ->where('requests.receive_id', '=', $user_id)
                ->join('request_info', 'requests.id', '=', 'request_info.request_id')
                ->orderBy('requests.updated_at', 'desc')
                ->get();
        $user = new User();
        foreach ($tasks as $task) {

            $users = $user->getAccountInfoByUserID($task->send_id);
            $task->name = $users[0]->name;

            $created = date_create($task->created_at);
            $now = date_create(date('Y-m-d h:i:sa'));
            $interval = date_diff($created, $now);
            if($interval->format('%d') > 0)
                $task->interval = $interval->format('%d day');

            if($interval->format('%d') == 0 && $interval->format('%h') > 0)
                $task->interval = $interval->format("%h hour");

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') > 0)
                $task->interval = $interval->format('%i minutes');

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $task->interval = $interval->format('%sa seconds');

            $userTask = UserTask::where('task_id', '=', $task->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->get();
            if(count($userTask) > 0) {
                $task->unread = true;
            } else {
                $task->unread = false;
            }
        }

        return $tasks;
    }

    public function getBrandTasksByID($user_id) {
        $tasks = DB::table('requests')
                ->where('send_id', '=', $user_id)
                ->join('request_info', 'requests.id', '=', 'request_info.request_id')
                ->orderBy('requests.updated_at', 'desc')
                ->get();
        $user = new User();
        foreach ($tasks as $task) {
            $users = $user->getAccountInfoByUserID($task->receive_id);
            $task->name = $users[0]->name;

            $created = date_create($task->created_at);
            $now = date_create(date('Y-m-d h:i:sa'));
            $interval = date_diff($created, $now);
            if($interval->format('%d') > 0) $task->interval = $interval->format('%d day');

            if($interval->format('%d') == 0 && $interval->format('%h') > 0)
                $task->interval = $interval->format("%h hour");

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') > 0)
                $task->interval = $interval->format('%i minutes');

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $task->interval = $interval->format('%sa seconds');

            $userTask = UserTask::where('task_id', '=', $task->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->get();
            if(count($userTask) > 0) {
                $task->unread = true;
            } else {
                $task->unread = false;
            }
        }

        return $tasks;
    }

    public function getRequestInfoByID($request_id) {
        // echo $request_id;
        $request = DB::table('requests')
                ->where('requests.id', '=', $request_id)
                ->join('request_info', 'requests.id', '=', 'request_info.request_id')
                ->get();
        $request = $request[0];
        $user_id = ($request->send_id == Auth::user()->id) ? $request->receive_id : $request->send_id;

        $request->user_id = $user_id;

        return $request;
    }
}
