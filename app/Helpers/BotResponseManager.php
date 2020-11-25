<?php


namespace App\Helpers;


use App\Jobs\BotSendMessage;
use App\Models\Member;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BotResponseManager
{

    private function _validate($text, $code)
    {
        $rules = [
            Message::CODES['ENTER_BDATE'] => [
                'text' => 'required|date'
            ],
            Message::CODES['ENTER_NAME'] => [
                'text' => 'required|max:100'
            ]
        ];

        $validator = Validator::make(["text" => $text], $rules[$code]);
        return !$validator->fails();
    }

    public function getResponseMessage($memberId, $messageText)
    {
        $member = Member::find($memberId);
        if(!$member) {
            return __('botMessages.not_working');
        }

        $lastMessage = Message::whereMemberId($memberId)->where('expired_at', '<', Carbon::now()->sub(1, 'day'))->latest('created_at')->first();
        if (!$lastMessage) {
            return __('botMessages.no_answer');
        }

        if (!$this->_validate($messageText, $lastMessage->message_code)) {
            return __('botMessages.validation_' . $lastMessage->message_code);
        }

        $responseMessage = '';
        switch ($lastMessage->message_code) {
            case 0:

                $member = Member::find($memberId);
                $member->date_of_birth = $messageText;
                $member->save();

                $responseMessage = __('botMessages.' . Message::CODES['ENTER_NAME']);

                $message = new Message();
                $message->member_id = $memberId;
                $message->message_code =  Message::CODES['ENTER_NAME'];
                $message->save();
                break;

            case 1:
                $member = Member::find($memberId);
                $member->name = $messageText;
                $member->save();
                $responseMessage = __('botMessages.' . Message::CODES['verified']);
                break;
        }


        return $responseMessage;
    }

}
