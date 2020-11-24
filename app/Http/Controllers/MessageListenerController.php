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

        $MadelineProto = new API('session.new', $settings);
        $MadelineProto->startAndLoop(BotMessagesListener::class);
    }

    public function stop() {
        $settings = [
            'logger' => [
                'logger_level' => 5
            ],
            'serialization' => [
                'serialization_interval' => 30,
            ],
        ];
        $MadelineProto = new API('session.new', $settings);
        $MadelineProto->stop();
    }

}
