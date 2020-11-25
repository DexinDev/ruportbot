<?php

use App\Helpers\BotMessagesListener;
use danog\MadelineProto\API;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('messages-listener', function () {
    $settings = [
        'logger' => [
            'logger_level' => 5
        ],
        'serialization' => [
            'serialization_interval' => 30,
        ],
    ];

    $MadelineProto = new API('session.new', $settings);
    $MadelineProto->startAndLoop(BotMessagesListener::class);
})->purpose('Display an inspiring quote');
