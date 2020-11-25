<?php

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['get', 'post'], '/', ['uses'=> 'AuthController@view'])->middleware('auth');
Route::match(['get', 'post'], '/updateMembers', ['uses'=> 'ChatMembersController@updateMembers'])->middleware('auth');
//Route::match(['get', 'post'], '/runMessageListener', ['uses'=> 'MessageListenerController@start'])->middleware('auth');
Route::match(['get', 'post'], '/stopMessageListener', ['uses'=> 'MessageListenerController@stop'])->middleware('auth');

Route::get('/test', function(){
    Debugbar::info(1);
    return Message::whereMemberId('74861527')->where('expired_at', '<', Carbon::now()->sub(1, 'day'))->orWhere('expired_at','=', NULL)->latest('created_at')->first();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
