<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RequestInfo;
use App\Models\Requests;
use App\Models\User;
use App\Models\Deposits;
use App\Models\Inboxes;
use App\Models\InboxInfo;
use App\Models\WalletAction;
use App\Models\WalletUser;
use App\Models\Wallet;
use App\Models\UserTask;
use App\Models\Referral;
use App\Models\RequestChat;
use Stripe\Stripe;
use Pusher;
use Session;

class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function depositFunds(Request $request) {
        $input = $request->all();
        $paymentMethod = $input['payment_id'];
        $price = $input['price'];
        $currency = $input['currency'];

        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $paymentIntent = \Stripe\PaymentIntent::create([
            'payment_method' => $paymentMethod,
            'amount' => $price * 100,
            'currency' => strtolower($currency),
            'confirm' => true
        ]);

        $walletUser = WalletUser::where('user_id', '=', Auth::user()->id)->first();
        $wallet_id = $walletUser->wallet_id;

        $walletAction = new WalletAction;
        $walletAction->wallet_id = $wallet_id;
        $walletAction->amount = $price;
        $walletAction->action = 'deposit funds';
        $walletAction->currency = $currency;
        $walletAction->aaa = '+';
        $walletAction->save();

        $wallet = Wallet::find($wallet_id);
        switch ($currency) {
            case 'usd':
                $wallet->usd_balance += $price;
                break;
            case 'gbp':
                $wallet->gbp_balance += $price;
                break;
            case 'eur':
                $wallet->eur_balance += $price;
                break;
            case 'aed':
                $wallet->aed_balance += $price;
                break;
            case 'aud':
                $wallet->aud_balance += $price;
                break;
            case 'bgn':
                $wallet->bgn_balance += $price;
                break;
            case 'brl':
                $wallet->brl_balance += $price;
                break;
            case 'cad':
                $wallet->cad_balance += $price;
                break;
            case 'chf':
                $wallet->chf_balance += $price;
                break;
            case 'czk':
                $wallet->czk_balance += $price;
                break;
            case 'dkk':
                $wallet->dkk_balance += $price;
                break;
            case 'hkd':
                $wallet->hkd_balance += $price;
                break;
            case 'huf':
                $wallet->huf_balance += $price;
                break;
            case 'inr':
                $wallet->inr_balance += $price;
                break;
            case 'jpy':
                $wallet->jpy_balance += $price;
                break;
            case 'mxn':
                $wallet->mxn_balance += $price;
                break;
            case 'myr':
                $wallet->myr_balance += $price;
                break;
            case 'nok':
                $wallet->nok_balance += $price;
                break;
            case 'pln':
                $wallet->pln_balance += $price;
                break;
            case 'ron':
                $wallet->ron_balance += $price;
                break;
            case 'sek':
                $wallet->sek_balance += $price;
                break;
            case 'sgd':
                $wallet->sgd_balance += $price;
                break;
            default:
                break;
        }
        $wallet->save();

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function withdraw(Request $request) {
        $input = $request->all();
        $price = $input['price'];
        $currency = $input['currency'];
        $user = User::find(Auth::user()->id);

        // check ability
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $account_info = $stripe->accounts->retrieve(
            Auth::user()->stripe_id,
            []
        );
        if(!$account_info->charges_enabled) {
            $walletUser = WalletUser::where('user_id', '=', Auth::user()->id)->get();
            $wallet_id = $walletUser[0]->wallet_id;

            $walletAction = WalletAction::where('wallet_id', '=', $wallet_id)->get();

            $wallet = Wallet::find($wallet_id);

            return view('wallet', [
                'page' => 5,
                'unread' => $request->get('unread'),
                'wallet' => $wallet,
                'walletActions' => $walletAction,
                'message' => "Please complete the stripe account to withdraw your money",
            ]);
        }


        // check balance
        $walletUser = WalletUser::where('user_id', '=', $user->id)->first();
        $wallet_id = $walletUser->wallet_id;
        $wallet = Wallet::find($wallet_id);
        $check = true;
        switch ($currency) {
            case 'usd':
                if($wallet->usd_balance < $price)
                    $check = false;
                break;
            case 'gbp':
                if($wallet->gbp_balance < $price)
                    $check = false;
                break;
            case 'eur':
                if($wallet->eur_balance < $price)
                    $check = false;
                break;
            case 'aed':
                if($wallet->aed_balance < $price)
                    $check = false;
                break;
            case 'aud':
                if($wallet->aud_balance < $price)
                    $check = false;
                break;
            case 'bgn':
                if($wallet->bgn_balance < $price)
                    $check = false;
                break;
            case 'brl':
                if($wallet->brl_balance < $price)
                    $check = false;
                break;
            case 'cad':
                if($wallet->cad_balance < $price)
                    $check = false;
                break;
            case 'chf':
                if($wallet->chf_balance < $price)
                    $check = false;
                break;
            case 'czk':
                if($wallet->czk_balance < $price)
                    $check = false;
                break;
            case 'dkk':
                if($wallet->dkk_balance < $price)
                    $check = false;
                break;
            case 'hkd':
                if($wallet->hkd_balance < $price)
                    $check = false;
                break;
            case 'huf':
                if($wallet->huf_balance < $price)
                    $check = false;
                break;
            case 'inr':
                if($wallet->inr_balance < $price)
                    $check = false;
                break;
            case 'jpy':
                if($wallet->jpy_balance < $price)
                    $check = false;
                break;
            case 'mxn':
                if($wallet->mxn_balance < $price)
                    $check = false;
                break;
            case 'myr':
                if($wallet->myr_balance < $price)
                    $check = false;
                break;
            case 'nok':
                if($wallet->nok_balance < $price)
                    $check = false;
                break;
            case 'pln':
                if($wallet->pln_balance < $price)
                    $check = false;
                break;
            case 'ron':
                if($wallet->ron_balance < $price)
                    $check = false;
                break;
            case 'sek':
                if($wallet->sek_balance < $price)
                    $check = false;
                break;
            case 'sgd':
                if($wallet->sgd_balance < $price)
                    $check = false;
                break;
            default:
                break;
        }
        if(!$check) {
            $walletUser = WalletUser::where('user_id', '=', Auth::user()->id)->get();
            $wallet_id = $walletUser[0]->wallet_id;

            $walletAction = WalletAction::where('wallet_id', '=', $wallet_id)->get();

            $wallet = Wallet::find($wallet_id);

            return view('wallet', [
                'page' => 5,
                'unread' => $request->get('unread'),
                'wallet' => $wallet,
                'walletActions' => $walletAction,
                'message' => "Not enough balance. Check your balance.",
            ]);
        }

        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $paymentIntent = \Stripe\Transfer::create([
            'amount' => $price * 100,
            'currency' => strtolower($currency),
            'destination' => $user->stripe_id
        ]);

        $walletAction = new WalletAction;
        $walletAction->wallet_id = $wallet_id;
        $walletAction->amount = $price;
        $walletAction->action = 'withdraw funds';
        $walletAction->currency = $currency;
        $walletAction->aaa = '-';
        $walletAction->save();

        switch ($currency) {
            case 'usd':
                $wallet->usd_balance -= $price;
                break;
            case 'gbp':
                $wallet->gbp_balance -= $price;
                break;
            case 'eur':
                $wallet->eur_balance -= $price;
                break;
            case 'aed':
                $wallet->aed_balance -= $price;
                break;
            case 'aud':
                $wallet->aud_balance -= $price;
                break;
            case 'bgn':
                $wallet->bgn_balance -= $price;
                break;
            case 'brl':
                $wallet->brl_balance -= $price;
                break;
            case 'cad':
                $wallet->cad_balance -= $price;
                break;
            case 'chf':
                $wallet->chf_balance -= $price;
                break;
            case 'czk':
                $wallet->czk_balance -= $price;
                break;
            case 'dkk':
                $wallet->dkk_balance -= $price;
                break;
            case 'hkd':
                $wallet->hkd_balance -= $price;
                break;
            case 'huf':
                $wallet->huf_balance -= $price;
                break;
            case 'inr':
                $wallet->inr_balance -= $price;
                break;
            case 'jpy':
                $wallet->jpy_balance -= $price;
                break;
            case 'mxn':
                $wallet->mxn_balance -= $price;
                break;
            case 'myr':
                $wallet->myr_balance -= $price;
                break;
            case 'nok':
                $wallet->nok_balance -= $price;
                break;
            case 'pln':
                $wallet->pln_balance -= $price;
                break;
            case 'ron':
                $wallet->ron_balance -= $price;
                break;
            case 'sek':
                $wallet->sek_balance -= $price;
                break;
            case 'sgd':
                $wallet->sgd_balance -= $price;
                break;
            default:
                break;
        }
        $wallet->save();

        $walletUser = WalletUser::where('user_id', '=', $user->id)->get();
        $wallet_id = $walletUser[0]->wallet_id;

        $walletAction = WalletAction::where('wallet_id', '=', $wallet_id)->get();

        $wallet = Wallet::find($wallet_id);

        return view('wallet', [
            'page' => 5,
            'unread' => $request->get('unread'),
            'wallet' => $wallet,
            'walletActions' => $walletAction,
        ]);
    }

    public function createDeposit($request_id) {
        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->first();
        $walletUser = WalletUser::where('user_id', '=', Auth::user()->id)->get();
        $wallet_id = $walletUser[0]->wallet_id;
        $wallet = Wallet::find($wallet_id);
        $price = $requestInfo->amount;
        $currency = $requestInfo->unit;
        $check = true;
        switch ($currency) {
            case 'usd':
                if($wallet->usd_balance < $price)
                    $check = false;
                break;
            case 'gbp':
                if($wallet->gbp_balance < $price)
                    $check = false;
                break;
            case 'eur':
                if($wallet->eur_balance < $price)
                    $check = false;
                break;
            case 'aed':
                if($wallet->aed_balance < $price)
                    $check = false;
                break;
            case 'aud':
                if($wallet->aud_balance < $price)
                    $check = false;
                break;
            case 'bgn':
                if($wallet->bgn_balance < $price)
                    $check = false;
                break;
            case 'brl':
                if($wallet->brl_balance < $price)
                    $check = false;
                break;
            case 'cad':
                if($wallet->cad_balance < $price)
                    $check = false;
                break;
            case 'chf':
                if($wallet->chf_balance < $price)
                    $check = false;
                break;
            case 'czk':
                if($wallet->czk_balance < $price)
                    $check = false;
                break;
            case 'dkk':
                if($wallet->dkk_balance < $price)
                    $check = false;
                break;
            case 'hkd':
                if($wallet->hkd_balance < $price)
                    $check = false;
                break;
            case 'huf':
                if($wallet->huf_balance < $price)
                    $check = false;
                break;
            case 'inr':
                if($wallet->inr_balance < $price)
                    $check = false;
                break;
            case 'jpy':
                if($wallet->jpy_balance < $price)
                    $check = false;
                break;
            case 'mxn':
                if($wallet->mxn_balance < $price)
                    $check = false;
                break;
            case 'myr':
                if($wallet->myr_balance < $price)
                    $check = false;
                break;
            case 'nok':
                if($wallet->nok_balance < $price)
                    $check = false;
                break;
            case 'pln':
                if($wallet->pln_balance < $price)
                    $check = false;
                break;
            case 'ron':
                if($wallet->ron_balance < $price)
                    $check = false;
                break;
            case 'sek':
                if($wallet->sek_balance < $price)
                    $check = false;
                break;
            case 'sgd':
                if($wallet->sgd_balance < $price)
                    $check = false;
                break;
            default:
                break;
        }

        if(!$check) {
            return response()->json([
                'data' => 'not enough balance',
            ]);
        }

        $requestInfo->status = 2;
        $requestInfo->save();

        $request = Requests::find($request_id);
        $user_id = $request->send_id;
        $user = User::find($user_id);

        $user1_id = $request->receive_id;
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

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'request_status',
            'request_id' => $request_id,
            'status' => 2,
        ]);

        $walletAction = new WalletAction;
        $walletAction->wallet_id = $wallet_id;
        $walletAction->amount = $requestInfo->amount;
        $walletAction->action = 'create deposit';
        $walletAction->currency = $requestInfo->unit;
        $walletAction->aaa = '-';
        $walletAction->save();

        $wallet = Wallet::find($wallet_id);
        switch ($requestInfo->unit) {
            case 'usd':
                $wallet->usd_balance -= $requestInfo->amount;
                break;
            case 'gbp':
                $wallet->gbp_balance -= $requestInfo->amount;
                break;
            case 'eur':
                $wallet->eur_balance -= $requestInfo->amount;
                break;
            case 'aed':
                $wallet->aed_balance -= $requestInfo->amount;
                break;
            case 'aud':
                $wallet->aud_balance -= $requestInfo->amount;
                break;
            case 'bgn':
                $wallet->bgn_balance -= $requestInfo->amount;
                break;
            case 'brl':
                $wallet->brl_balance -= $requestInfo->amount;
                break;
            case 'cad':
                $wallet->cad_balance -= $requestInfo->amount;
                break;
            case 'chf':
                $wallet->chf_balance -= $requestInfo->amount;
                break;
            case 'czk':
                $wallet->czk_balance -= $requestInfo->amount;
                break;
            case 'dkk':
                $wallet->dkk_balance -= $requestInfo->amount;
                break;
            case 'hkd':
                $wallet->hkd_balance -= $requestInfo->amount;
                break;
            case 'huf':
                $wallet->huf_balance -= $requestInfo->amount;
                break;
            case 'inr':
                $wallet->inr_balance -= $requestInfo->amount;
                break;
            case 'jpy':
                $wallet->jpy_balance -= $requestInfo->amount;
                break;
            case 'mxn':
                $wallet->mxn_balance -= $requestInfo->amount;
                break;
            case 'myr':
                $wallet->myr_balance -= $requestInfo->amount;
                break;
            case 'nok':
                $wallet->nok_balance -= $requestInfo->amount;
                break;
            case 'pln':
                $wallet->pln_balance -= $requestInfo->amount;
                break;
            case 'ron':
                $wallet->ron_balance -= $requestInfo->amount;
                break;
            case 'sek':
                $wallet->sek_balance -= $requestInfo->amount;
                break;
            case 'sgd':
                $wallet->sgd_balance -= $requestInfo->amount;
                break;
            default:
                break;
        }
        $wallet->save();

        $userTask = new UserTask;
        $userTask->task_id = $request_id;
        $userTask->user_id = $request->receive_id;
        $userTask->isRead = 0;
        $userTask->save();

        $pusher->trigger('fluenser-channel', 'fluenser-event', [
            'trigger' => 'newTask',
            'request' => $request,
        ]);

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function releaseDeposit($request_id) {
        $requestInfo = RequestInfo::where('request_id', '=', $request_id)->first();
        $request = Requests::find($request_id);
        $user_id = $request->receive_id;
        $user = User::find($user_id);
        $walletUser = WalletUser::where('user_id', '=', $user->id)->get();
        $wallet_id = $walletUser[0]->wallet_id;
        $wallet = Wallet::find($wallet_id);
        $price = $requestInfo->amount;
        $currency = $requestInfo->unit;

        $walletAction = new WalletAction;
        $walletAction->wallet_id = $wallet_id;
        $walletAction->amount = ($price * 85 / 100);
        $walletAction->action = 'get payed';
        $walletAction->currency = $currency;
        $walletAction->aaa = '+';
        $walletAction->save();

        $wallet = Wallet::find($wallet_id);
        switch ($currency) {
            case 'usd':
                $wallet->usd_balance += ($price * 85 / 100);
                break;
            case 'gbp':
                $wallet->gbp_balance += ($price * 85 / 100);
                break;
            case 'eur':
                $wallet->eur_balance += ($price * 85 / 100);
                break;
            case 'aed':
                $wallet->aed_balance += ($price * 85 / 100);
                break;
            case 'aud':
                $wallet->aud_balance += ($price * 85 / 100);
                break;
            case 'bgn':
                $wallet->bgn_balance += ($price * 85 / 100);
                break;
            case 'brl':
                $wallet->brl_balance += ($price * 85 / 100);
                break;
            case 'cad':
                $wallet->cad_balance += ($price * 85 / 100);
                break;
            case 'chf':
                $wallet->chf_balance += ($price * 85 / 100);
                break;
            case 'czk':
                $wallet->czk_balance += ($price * 85 / 100);
                break;
            case 'dkk':
                $wallet->dkk_balance += ($price * 85 / 100);
                break;
            case 'hkd':
                $wallet->hkd_balance += ($price * 85 / 100);
                break;
            case 'huf':
                $wallet->huf_balance += ($price * 85 / 100);
                break;
            case 'inr':
                $wallet->inr_balance += ($price * 85 / 100);
                break;
            case 'jpy':
                $wallet->jpy_balance += ($price * 85 / 100);
                break;
            case 'mxn':
                $wallet->mxn_balance += ($price * 85 / 100);
                break;
            case 'myr':
                $wallet->myr_balance += ($price * 85 / 100);
                break;
            case 'nok':
                $wallet->nok_balance += ($price * 85 / 100);
                break;
            case 'pln':
                $wallet->pln_balance += ($price * 85 / 100);
                break;
            case 'ron':
                $wallet->ron_balance += ($price * 85 / 100);
                break;
            case 'sek':
                $wallet->sek_balance += ($price * 85 / 100);
                break;
            case 'sgd':
                $wallet->sgd_balance += ($price * 85 / 100);
                break;
            default:
                break;
        }
        $wallet->save();

        // check if has a referral user
        $referral = Referral::where('referral_user_id', '=', $user_id)->get();
        if(count($referral) > 0) {
            $ref_user_id = $referral[0]->user_id;
            $walletUser = WalletUser::where('user_id', '=', $ref_user_id)->get();
            $wallet_id = $walletUser[0]->wallet_id;
            $wallet = Wallet::find($wallet_id);

            $walletAction = new WalletAction;
            $walletAction->wallet_id = $wallet_id;
            $walletAction->amount = ($price * 10 / 100);
            $walletAction->action = 'get referral paid';
            $walletAction->currency = $currency;
            $walletAction->aaa = '+';
            $walletAction->save();

            $wallet = Wallet::find($wallet_id);
            switch ($currency) {
                case 'usd':
                    $wallet->usd_balance += ($price * 10 / 100);
                    break;
                case 'gbp':
                    $wallet->gbp_balance += ($price * 10 / 100);
                    break;
                case 'eur':
                    $wallet->eur_balance += ($price * 10 / 100);
                    break;
                case 'aed':
                    $wallet->aed_balance += ($price * 10 / 100);
                    break;
                case 'aud':
                    $wallet->aud_balance += ($price * 10 / 100);
                    break;
                case 'bgn':
                    $wallet->bgn_balance += ($price * 10 / 100);
                    break;
                case 'brl':
                    $wallet->brl_balance += ($price * 10 / 100);
                    break;
                case 'cad':
                    $wallet->cad_balance += ($price * 10 / 100);
                    break;
                case 'chf':
                    $wallet->chf_balance += ($price * 10 / 100);
                    break;
                case 'czk':
                    $wallet->czk_balance += ($price * 10 / 100);
                    break;
                case 'dkk':
                    $wallet->dkk_balance += ($price * 10 / 100);
                    break;
                case 'hkd':
                    $wallet->hkd_balance += ($price * 10 / 100);
                    break;
                case 'huf':
                    $wallet->huf_balance += ($price * 10 / 100);
                    break;
                case 'inr':
                    $wallet->inr_balance += ($price * 10 / 100);
                    break;
                case 'jpy':
                    $wallet->jpy_balance += ($price * 10 / 100);
                    break;
                case 'mxn':
                    $wallet->mxn_balance += ($price * 10 / 100);
                    break;
                case 'myr':
                    $wallet->myr_balance += ($price * 10 / 100);
                    break;
                case 'nok':
                    $wallet->nok_balance += ($price * 10 / 100);
                    break;
                case 'pln':
                    $wallet->pln_balance += ($price * 10 / 100);
                    break;
                case 'ron':
                    $wallet->ron_balance += ($price * 10 / 100);
                    break;
                case 'sek':
                    $wallet->sek_balance += ($price * 10 / 100);
                    break;
                case 'sgd':
                    $wallet->sgd_balance += ($price * 10 / 100);
                    break;
                default:
                    break;
            }
            $wallet->save();
        }

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

    public function balance(Request $request) {
        $walletUser = WalletUser::where('user_id', '=', Auth::user()->id)->get();
        $wallet_id = $walletUser[0]->wallet_id;

        $walletAction = WalletAction::where('wallet_id', '=', $wallet_id)->get();

        $wallet = Wallet::find($wallet_id);

        return view('wallet', [
            'page' => 5,
            'unread' => $request->get('unread'),
            'wallet' => $wallet,
            'walletActions' => $walletAction,
        ]);
    }

    public function checkout(Request $request) {
        $input = $request->all();
        $price = $input['price'];
        $currency = $input['currency'];

        return view('checkout', [
            'page' => 5,
            'unread' => $request->get('unread'),
            'price' => $price,
            'currency' => $currency,
        ]);
    }
}
