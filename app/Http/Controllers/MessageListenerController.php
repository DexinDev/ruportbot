<?php


namespace App\Http\Controllers;


use App\Helpers\BotMessagesListener;
use danog\MadelineProto\API;
use Illuminate\Routing\Controller as BaseController;

class MessageListenerController extends BaseController
{

    public function start() {
        $settings = [
            'logger' => [
                'logger_level' => 5
            ],
            'serialization' => [
                'serialization_interval' => 30,
            ],
        ];

        $MadelineProto = new API('bot.listener', $settings);
        $MadelineProto->startAndLoop(BotMessagesListener::class);
    }

}
