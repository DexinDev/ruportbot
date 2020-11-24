<?php


namespace App\Helpers;


use App\Jobs\BotSendMessage;
use App\Models\Message;

class BotResponseManager
{

    private function _validate($text, $code) {
        $rules = [
            Message::CODES['ENTER_BDATE'] => [
                'text' => 'regex:/\d\d\.\d\d.\d\d\d\d/'
            ]
        ];

        return Validator::make(["text" => $text], $rules[$code])->validate();
    }

    public function makeResponse($memberId, $messageText)
    {
        $lastMessage = Message::whereMemberId($memberId)->latest();
        if(!$lastMessage) {
            return BotSendMessage::dispatch($memberId, Message::CODES['NO_REQUEST']);
        }

        if(!$this->_validate($messageText, $lastMessage->message_code)) {
            return BotSendMessage::dispatch($memberId, $lastMessage->message_code);
        }


    }

}
