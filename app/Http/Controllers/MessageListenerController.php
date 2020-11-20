<?php


namespace App\Http\Controllers;


use App\Helpers\BotHelper;
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

        $MadelineProto = new API('madeline.listener', $settings);
        $MadelineProto->startAndLoop(BotHelper::class);
    }

}
