<?php


namespace App\Http\Controllers;


use App\Models\Bot;
use App\Models\Member;
use App\Models\Message;
use Illuminate\Routing\Controller as BaseController;


class ChatMembersController extends BaseController
{
    public function updateMembers()
    {
        $bot = new Bot();
        $members = $bot->getChatMembers();


        foreach ($members as $chatMember) {
            $member = Member::findOrNew($chatMember['user']['id']);
            $member->telegram_id = $chatMember['user']['id'];
            $member->telegram_name = $chatMember['user']['first_name'] . ' ' . $chatMember['user']['last_name'];
            $member->username = $chatMember['user']['username'];
            $member->save();
        }

        $newMembers = Member::whereIsConfirmed(false)->get();

        $statuses = [];

        foreach ($newMembers as $member) {
            $message = __('botMessages.' . Message::CODES['ENTER_BDATE']);
            $statuses[] = $bot->message($member->telegram_id, $message);
        }

        return $statuses;
    }
}
