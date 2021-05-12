<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Pusher;
use Illuminate\Http\Request;
use App\Http\Resources\Inbox as InboxResource;
use App\Http\Resources\InboxCollection;
use App\Models\Inboxes;
use App\Models\InboxInfo;
use App\Models\Requests;
use App\Models\RequestInfo;
use App\Models\RequestChat;
use App\Models\RequestImg;
use App\Models\User;
use App\Models\UserInbox;
use App\Models\UserRequest;
use App\Models\UserTask;
use App\Models\DisputeChat;

class MessageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $account = new User();
        $accountInfo = $account->getAccountInfoByUserID(Auth::user()->id);

        $unread = $request->get('unread');

        return view('message', [
            'page' => 2,
            'unread' => $unread,
            'accountInfo' => $accountInfo[0]
        ]);
    }

    public function inbox() {
        $user_id = Auth::user()->id;

        $user = new User();
        $accountInfo = $user->getAccountInfoByUserID($user_id);

        $inboxes = new Inboxes();
        $inboxesInfo = $inboxes->where('user1_id', $user_id)
                ->orWhere('user2_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->get();
        if(count($inboxesInfo) > 0) {
            $i = 0;
            foreach($inboxesInfo as $inboxInfo){
                $contact_id = ($inboxInfo->user1_id == $user_id) ? $inboxInfo->user2_id : $inboxInfo->user1_id;
                $account = new User;
                $accountInfo = $account->getAccountInfoByUserID($contact_id);
                if($accountInfo != 'none'){
                    $inboxesInfo[$i]->accountInfo = $accountInfo;
                }

                $inboxContent = InboxInfo::where('inbox_id', $inboxInfo->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(1)
                            ->get();
                $inboxesInfo[$i]->inboxContent = $inboxContent;
                $inboxesInfo[$i]->contactID = $contact_id;

                $userInbox = UserInbox::where("inbox_id", '=', $inboxInfo->id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->get();

                if(count($userInbox) > 0) {
                    $inboxesInfo[$i]->unread = true;
                } else {
                    $inboxesInfo[$i]->unread = false;
                }

                $i ++;
            }
        }

        return response()->json([
            'accountInfo' => $accountInfo[0],
            'data' => $inboxesInfo,
            'user_id' => $user_id,
        ]);
    }

    public function requests() {
        $user_id = Auth::user()->id;
        $account = new User();
        $influencerInfo = $account->getAccountInfoByUserID($user_id);

        $requestsInfos = [];

        $requests = new Requests();
        $requestsInfo = $requests->where('receive_id', $user_id)
                ->orWhere('send_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->get();
        if(count($requestsInfo) > 0) {
            $i = 0;
            foreach($requestsInfo as $requestInfo){
                $contact_id = ($requestInfo->send_id == $user_id) ? $requestInfo->receive_id : $requestInfo->send_id;
                $account = new User;
                $accountInfo = $account->getAccountInfoByUserID($contact_id);
                if($accountInfo != 'none'){
                    $requestsInfo[$i]->accountInfo = $accountInfo;
                }

                $temp = new RequestInfo();
                $requestContent = $temp->getRequestInfoByID($requestInfo->id);
                if($requestContent->status == 1) {
                    $requestsInfo[$i]->requestContent = $requestContent;
                    $requestsInfo[$i]->contactID = $contact_id;

                    $userRequest = UserRequest::where('request_id', '=', $requestInfo->id)
                            ->where('user_id', '=', Auth::user()->id)
                            ->get();
                    if(count($userRequest) > 0)
                        $requestsInfo[$i]->unread = true;
                    else
                        $requestsInfo[$i]->unread = false;

                    array_push($requestsInfos, $requestsInfo[$i]);
                    $i ++;
                }
            }
        }

        return response()->json([
            'data' => $requestsInfos,
            'user_id' => $user_id,
        ]);
    }

    public function rejectRequest($request_id) {
        $requests = Requests::find($request_id);
        $requests->delete();

        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->first();
        $requestInfo->delete();

        return response()->json([
            'data' => 'success'
        ]);
    }

    public function completeRequest($request_id) {
        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->get();
        $requestInfo = $requestInfo[0];
        $requestInfo->status = 3;
        $requestInfo->save();

        $pusher = new Pusher\Pusher('da7cd3b12e18c9e2e461', '566ee6622fcab95b7709', '1168466', array('cluster' => 'eu'));

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'request_status',
            'request_id' => $request_id,
            'status' => 3,
        ]);

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function acceptRequest($request_id) {
        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->first();
        $requestInfo->status = 2;
        $requestInfo->save();

        $request = Requests::find($request_id);
        $user_id = $request->receive_id;
        $user = User::find($user_id);

        $user1_id = $request->send_id;
        $chat = new Inboxes;
        $chat->user1_id = $user1_id;
        $chat->user2_id = $user_id;
        $chat->request_id = $request_id;
        $chat->user1_block = 0;
        $chat->user2_block = 0;
        $chat->save();

        $pusher = new Pusher\Pusher('da7cd3b12e18c9e2e461', '566ee6622fcab95b7709', '1168466', array('cluster' => 'eu'));

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'newInbox',
            'request' => $request,
        ]);

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'request_status',
            'request_id' => $request_id,
            'status' => 2,
        ]);


        $requestChats = RequestChat::where('request_id', '=', $request_id)->get();
        foreach ($requestChats as $requestChat) {
          $chatInfo = new InboxInfo;
          $chatInfo->inbox_id = $chat->id;
          $chatInfo->send_id = $requestChat->send_id;
          $chatInfo->receive_id = $requestChat->receive_id;
          $chatInfo->content = $requestChat->content;
          $chatInfo->upload = $requestChat->upload;
          $chatInfo->save();
        }

        $userTask = new UserTask;
        $userTask->task_id = $request_id;
        $userTask->user_id = $request->send_id;
        $userTask->isRead = 0;
        $userTask->save();

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'newTask',
            'request' => $request,
        ]);

        return response()->json([
            'data' => 'success'
        ]);
    }

    public function chat($inbox_id) {
        $chat = new InboxInfo();
        $chatInfo = $chat->getChatInfo($inbox_id);
        $inboxes = new Inboxes;
        $inbox = $inboxes->where('id', $inbox_id)->get();
        $contactID = ($inbox[0]->user1_id == Auth::user()->id) ? $inbox[0]->user2_id : $inbox[0]->user1_id;
        $users = new User();
        $contactInfo = $users->getAccountInfoByUserID($contactID);
        $accountInfo = $users->getAccountInfoByUserID(Auth::user()->id);

        if(! $contactInfo[0]->loggedIn) {
            $updated = date_create($contactInfo[0]->updated_at);
            $now = date_create(date('Y-m-d h:i:sa'));
            $interval = date_diff($updated, $now);
            if($interval->format('%m') > 0)
                $contactInfo[0]->interval = $interval->format('%m month');
            if($interval->format('%m') == 0 && $interval->format('%h') > 0)
                $contactInfo[0]->interval = $interval->format("%h hour");
            if($interval->format('%h') == 0 && $interval->format('%m') == 0 && $interval->format('%i') > 0)
                $contactInfo[0]->interval = $interval->format('%i minutes');
            if($interval->format('%h') == 0 && $interval->format('%m') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $contactInfo[0]->interval = $interval->format('%sa seconds');
        } else {
            $contactInfo[0]->interval = '0';
        }


        return response()->json([
            'data' => $chatInfo,
            'contactInfo' => $contactInfo,
            'accountInfo' => $accountInfo,
            'contactID' => $contactID,
            'inbox' => $inbox[0],
        ]);
    }

    public function receiveMessage(Request $request) {
        $inbox_id = $request['inbox_id'];
        $msg = isset($request['msg']) ? $request['msg'] : '';
        $upload = isset($request['upload']) ? $request['upload'] : 'none';
        if($upload != 'none') {
            $disk = Storage::disk('local');
            $filename = time() . "_" . uniqid();
            $disk->put('/upload-image/'.$filename.'.jpg', file_get_contents($upload));
        } else {
            $filename = 'none';
        }

        $inboxes = new Inboxes;
        $inbox = $inboxes->find($inbox_id);
        $receive_id = ($inbox->user1_id == Auth::user()->id) ? $inbox->user2_id : $inbox->user1_id;
        $inbox->user1_id = Auth::user()->id;
        $inbox->user2_id = $receive_id;
        $inbox->save();

        $inboxInfo = new InboxInfo;
        $inboxInfo->inbox_id = $inbox_id;
        $inboxInfo->send_id = Auth::user()->id;
        $inboxInfo->receive_id = $receive_id;
        $inboxInfo->content =  $msg;
        $inboxInfo->upload = $filename;
        $inboxInfo->save();

        $pusher = new Pusher\Pusher('da7cd3b12e18c9e2e461', '566ee6622fcab95b7709', '1168466', array('cluster' => 'eu'));

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'chat',
            'inboxInfo' => $inboxInfo
        ]);

        $userInbox = UserInbox::where('inbox_id', '=', $inbox_id)
                ->where('user_id', '=', Auth::user()->id)
                ->get();
        if(count($userInbox) == 0) {
            $userInbox = new UserInbox;
            $userInbox->inbox_id = $inbox_id;
            $userInbox->user_id = $receive_id;
            $userInbox->isRead = 0;
            $userInbox->save();
        }

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'newInboxChat',
            'inboxInfo' => $inboxInfo,
        ]);

        return response()->json([
            'data' => true,
        ]);
    }

    public function receiveDisputeMessage(Request $request) {
        $request_id = $request['request_id'];
        $msg = isset($request['msg']) ? $request['msg'] : '';
        $upload = isset($request['upload']) ? $request['upload'] : 'none';
        if($upload != 'none') {
            $disk = Storage::disk('local');
            $filename = time() . "_" . uniqid();
            $disk->put('/upload-image/'.$filename.'.jpg', file_get_contents($upload));
        } else {
            $filename = 'none';
        }

        $disputeChat = new DisputeChat;
        $request = Requests::find($request_id);
        $receive_id = ($request->send_id == Auth::user()->id) ? $request->receive_id : $request->send_id;
        $disputeChat->request_id = $request_id;
        $disputeChat->send_id = Auth::user()->id;
        $disputeChat->receive_id = $receive_id;
        $disputeChat->content = $msg;
        $disputeChat->upload = $filename;
        $disputeChat->status = 0;
        $disputeChat->save();

        $pusher = new Pusher\Pusher('da7cd3b12e18c9e2e461', '566ee6622fcab95b7709', '1168466', array('cluster' => 'eu'));

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'disputeChat',
            'disputeChat' => $disputeChat
        ]);

        return response()->json([
            'data' => true,
        ]);
    }

    public function requestDetaliShow($request_id) {
        $requests = new Requests;
        $request = $requests->find($request_id);
        $send_id = ($request->send_id == Auth::user()->id)?$request->receive_id:$request->send_id;

        $user = new User();
        $contactInfo = $user->getAccountInfoByUserID($send_id)[0];
        $accountInfo = $user->getAccountInfoByUserID(Auth::user()->id)[0];

        if(! $contactInfo->loggedIn) {
            $updated = date_create($contactInfo->updated_at);
            $now = date_create(date('Y-m-d h:i:sa'));
            $interval = date_diff($updated, $now);
            if($interval->format('%m') > 0)
                $contactInfo->interval = $interval->format('%m month');
            if($interval->format('%m') == 0 && $interval->format('%h') > 0)
                $contactInfo->interval = $interval->format("%h hour");
            if($interval->format('%h') == 0 && $interval->format('%m') == 0 && $interval->format('%i') > 0)
                $contactInfo->interval = $interval->format('%i minutes');
            if($interval->format('%h') == 0 && $interval->format('%m') == 0 && $interval->format('%i') == 0 && $interval->format("%sa") > 0)
                $contactInfo->interval = $interval->format('%sa seconds');
        } else {
            $contactInfo->interval = '0';
        }

        $requestInfos = new RequestInfo();
        $requestInfo = $requestInfos->getRequestInfoByID($request_id);

        $requestChat = new RequestChat();
        $requestChats = $requestChat->getRequestChatInfo($request_id, $send_id, Auth::user()->id);

        // echo $accountInfo.'<br>'.$contactInfo;

        return response()->json([
            'accountInfo' => $accountInfo,
            'contactInfo' => $contactInfo,
            'requestInfo' => $requestInfo,
            'requestChats' => $requestChats,
        ]);
    }

    public function checkInbox($user1_id, $user2_id) {
        $inboxes = new Inboxes();
        $inbox = $inboxes->checkInbox($user1_id, $user2_id);

        return response()->json([
            'inbox_id' => $inbox->id,
        ]);
    }

    public function updateRequest($request_id, $price, $unit) {
        $request = RequestInfo::where('request_id', '=', $request_id)->get();

        $request = RequestInfo::find($request[0]->id);
        $request->amount = $price;
        $request->unit = $unit;
        $request->gift = 0;
        $request->save();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function saveRequestChat(Request $request) {
        $request_id = $request['request_id'];
        $send_id = $request['send_id'];
        $receive_id = $request['receive_id'];
        $msg = isset($request['message']) ? $request['message'] : '';
        $upload = isset($request['upload']) ? $request['upload'] : 'none';

        if($upload != 'none') {
            $disk = Storage::disk('local');
            $filename = time() . "_" . uniqid();
            $disk->put('/upload-image/'.$filename.'.jpg', file_get_contents($upload));
        } else {
            $filename = 'none';
        }

        $requestChat = new RequestChat;
        $requestChat->request_id = $request_id;
        $requestChat->send_id = $send_id;
        $requestChat->receive_id = $receive_id;
        $requestChat->content = $msg;
        $requestChat->upload = $filename;
        $requestChat->save();

        $pusher = new Pusher\Pusher('da7cd3b12e18c9e2e461', '566ee6622fcab95b7709', '1168466', array('cluster' => 'eu'));

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'requestChat',
            'requestChat' => $requestChat,
        ]);

        $userRequest = UserRequest::where('request_id', '=', $request_id)
                ->where('user_id', '=', $receive_id)
                ->get();
        if(count($userRequest) == 0) {
            $userRequest = new UserRequest;
            $userRequest->request_id = $request_id;
            $userRequest->user_id = $receive_id;
            $userRequest->isRead = 0;
            $userRequest->save();
        }

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'newRequestChat',
            'requestChat' => $requestChat,
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function readItem($item, $id) {
        switch ($item) {
            case 'request':
                $item = UserRequest::where('request_id', '=', $id);
                break;

            case 'inbox':
                $item = UserInbox::where('inbox_id', '=', $id);
                break;

            case 'tast':
                $item = UserTask::where('task_id', '=', $id);
                break;

            default:
                break;
        }

        $item = $item->where('user_id', '=', Auth::user()->id)->get();
        if(count($item) > 0) $item[0]->delete();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function dispute($request_id) {
        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->get();
        $requestInfo[0]->status = 5;
        $requestInfo[0]->save();

        $request = Requests::find($request_id);
        $user2_id = ($request->send_id == Auth::user()->id) ? $request->receive_id : $request->send_id;
        $disputeChat = new DisputeChat;
        $disputeChat->request_id = $request_id;
        $disputeChat->send_id = Auth::user()->id;
        $disputeChat->receive_id = $user2_id;
        $disputeChat->content = "Hello";
        $disputeChat->upload = "none";
        $disputeChat->status = 0;
        $disputeChat->save();

        $pusher = new Pusher\Pusher('da7cd3b12e18c9e2e461', '566ee6622fcab95b7709', '1168466', array('cluster' => 'eu'));

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'request_status',
            'request_id' => $request_id,
            'status' => 5,
        ]);

        return response()->json(["data" => true]);
    }

    public function block($request_id) {
        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->get();
        $requestInfo[0]->status = ($requestInfo[0]->status == 3) ? 4 : 3;
        $requestInfo[0]->save();
    }

    public function disputeChat(Request $request, $request_id) {
        return view('message', [
            'page' => 3,
            'unread' => $request->get('unread'),
            'item' => 'dispute',
            'request_id' => $request_id
        ]);
    }

    public function disputeChats($request_id) {
        $disputeChat = DisputeChat::where('send_id', '=', Auth::user()->id)
                ->orWhere('receive_id', '=', Auth::user()->id)
                ->orderBy('created_at')
                ->get();



        $disputeChats = [];
        foreach ($disputeChat as $chat) {
            if($chat->request_id == $request_id) {
                array_push($disputeChats, $chat);
            }
        }

        $user2_id = ($disputeChat[0]->send_id == Auth::user()->id)
                ? $disputeChat[0]->receive_id
                : $disputeChat[0]->send_id;
        $users = new User();
        $contactInfo = $users->getAccountInfoByUserID($user2_id);
        $accountInfo = $users->getAccountInfoByUserID(Auth::user()->id);

        return response()->json([
            'accountInfo' => $accountInfo[0],
            'contactInfo' => $contactInfo[0],
            'disputeChats' => $disputeChats,
            'request_id' => $request_id,
        ]);
    }

    public function blockChat($inbox_id, $user_id) {
        $inbox = Inboxes::find($inbox_id);
        if($inbox->user1_id == $user_id)
            $inbox->user1_block = ($inbox->user1_block == 1) ? 0 : 1;
        else
            $inbox->user2_block = ($inbox->user2_block == 1) ? 0 : 1;
        $inbox->save();

        return response()->json([
            "data"=>'success',
            "inbox" => $inbox,
        ]);
    }

    public function deleteInbox($inbox_id) {
      $inbox = Inboxes::find($inbox_id);
      $inbox->delete();

      $inboxInfo = InboxInfo::where('inbox_id', '=', $inbox_id)->get();
      if(count($inboxInfo) > 0) {
        foreach ($inboxInfo as $item) {
          $item->delete();
        }
      }

      return response()->json([
        'data' => 'success',
      ]);
    }
}
