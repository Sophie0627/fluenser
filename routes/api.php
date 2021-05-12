<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:api')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/inbox', [App\Http\Controllers\MessageController::class, 'inbox']);

    Route::get('/request', [App\Http\Controllers\MessageController::class, 'requests']);

    Route::get('/requestDetail/{request_id}', [App\Http\Controllers\MessageController::class, 'requestDetaliShow']);

    Route::get('/chat/{inbox_id}', [App\Http\Controllers\MessageController::class, 'chat']);

    Route::post('/sendMessage', [App\Http\Controllers\MessageController::class, 'receiveMessage']);

    Route::post('/sendDisputeMessage', [App\Http\Controllers\MessageController::class, 'receiveDisputeMessage']);

    Route::get('/checkInbox/{user1_id}/{user2_id}', [App\Http\Controllers\MessageController::class, 'checkInbox']);

    Route::get('/updateRequest/{request_id}/{price}/{unit}', [App\Http\Controllers\MessageController::class, 'updateRequest']);

    Route::post('/saveRequestChat', [App\Http\Controllers\MessageController::class, 'saveRequestChat']);

    Route::get('/acceptRequest/{request_id}', [App\Http\Controllers\MessageController::class, 'acceptRequest']);

    Route::get('/dispute/{request_id}', [App\Http\Controllers\MessageController::class, 'dispute']);

    Route::get('/disputeChats/{request_id}', [App\Http\Controllers\MessageController::class, 'disputeChats']);

    Route::post('/depositFunds', [App\Http\Controllers\PaymentController::class, 'depositFunds'])->name('depositFunds');

    Route::get('/releaseDeposit/{request_id}', [App\Http\Controllers\PaymentController::class, 'releaseDeposit'])->name('releaseDeposit');

    Route::get('/createDeposit/{request_id}', [App\Http\Controllers\PaymentController::class, 'createDeposit'])->name('createDeposit');

    Route::get('/read/{item}/{id}', [App\Http\Controllers\MessageController::class, 'readItem'])->name('readItem');

    Route::get('/savedToggle/{user2_id}', [App\Http\Controllers\ProfileController::class, 'saveToggle'])->name('savedToggle');

    Route::get('/rejectRequest/{request_id}', [App\Http\Controllers\MessageController::class, 'rejectRequest']);

    Route::get('/completeRequest/{request_id}', [App\Http\Controllers\MessageController::class, 'completeRequest']);

    Route::get('/deleteInbox/{inbox_id}', [App\Http\Controllers\MessageController::class, 'deleteInbox']);

    Route::get('/block/{inbox_id}/{user_id}', [App\Http\Controllers\MessageController::class, 'blockChat']);

    Route::post('/saveImage', [App\Http\Controllers\ProfileController::class, 'saveImage'])->name('savedImage');

    Route::post('/deleteImage', [App\Http\Controllers\ProfileController::class, 'deleteImage'])->name('deleteImage');

    Route::post('/submitReview', [App\Http\Controllers\CollaborateController::class, 'submitReview']);

    Route::get('/userLogOut', [App\Http\Controllers\HomeController::class, 'logOut'])->name('userLogOut');

    Route::get('/influencerRequest/{user_id}',[App\Http\Controllers\CollaborateController::class, 'influencerRequest'])->name('influencerRequest');
});
