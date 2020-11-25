<?php


namespace App\Helpers;


use App\Jobs\BotSendMessage;
use App\Models\Message;

class BotResponseManager
{

    private function _validate($text, $code)
    {
        $rules = [
            Message::CODES['ENTER_BDATE'] => [
                'text' => 'regex:/\d\d\.\d\d.\d\d\d\d/'
            ]
        ];

        return Validator::make(["text" => $text], $rules[$code])->validate();
    }

    public function getResponseMessageCode($memberId, $messageText)
    {
        $lastMessage = Message::whereMemberId($memberId)->latest('created_at')->first();
        if (!$lastMessage) {
            return Message::CODES['NO_REQUEST'];
        }

        if (!$this->_validate($messageText, $lastMessage->message_code)) {
            return $lastMessage->message_code;
        }
    }

    public function makeResponse($memberId, $messageText)
    {
        $responseMessageCode = $this->getResponseMessageCode($memberId, $messageText);
        return BotSendMessage::dispatch($memberId, $responseMessageCode);
    }

}
