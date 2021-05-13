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
            $now = date_create(gmdate('Y-m-d h:i:sa'));
            $interval = date_diff($created, $now);
            if($interval->format('%d') > 0)
                $task->interval = $interval->format('%d day');

            if($interval->format('%d') == 0 && $interval->format('%h') > 0)
                $task->interval = $interval->format("%h hour");

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') > 0)
                $task->interval = $interval->format('%i minutes');

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $task->interval = $interval->format('%s seconds');

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
            $now = date_create(gmdate('Y-m-d h:i:sa'));
            $interval = date_diff($created, $now);
            if($interval->format('%d') > 0) $task->interval = $interval->format('%d day');

            if($interval->format('%d') == 0 && $interval->format('%h') > 0)
                $task->interval = $interval->format("%h hour");

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') > 0)
                $task->interval = $interval->format('%i minutes');

            if($interval->format('%h') == 0 && $interval->format('%d') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $task->interval = $interval->format('%s seconds');

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

    public function getAllRequests($keyword) {
      $requests = DB::table('requests')
        ->join('request_info', 'requests.id', '=', 'request_info.request_id')
        ->join('users as A', 'A.id', '=', 'requests.send_id')
        ->join('users as B', 'B.id', '=', 'requests.receive_id')
        ->select('requests.id', 'request_info.title', 'request_info.gift', 'request_info.status', 'A.name as brand_name', 'B.name as influencer_name', 'requests.created_at')
        ->orderBy('requests.created_at', 'desc');
      if($keyword == '') return $requests->paginate(10);
      else return $requests->where('request_info.title', 'Like', '%'.$keyword.'%')
            ->orWhere('A.name', 'Like', '%'.$keyword.'%')
            ->orWhere('B.name', 'Like', '%'.$keyword.'%')
            ->paginate(10);
    }
}
