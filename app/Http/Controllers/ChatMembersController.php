<?php


namespace App\Http\Controllers;


use App\Jobs\BotSendMessage;
use App\Models\Bot;
use App\Models\Member;
use App\Models\Message;
use Illuminate\Routing\Controller as BaseController;


class ChatMembersController extends BaseController
{
    private function _saveMember($chatMember) {
        $chatMember['user']['first_name'] = isset($chatMember['user']['first_name']) ? $chatMember['user']['first_name']: '';
        $chatMember['user']['last_name'] = isset($chatMember['user']['last_name']) ? $chatMember['user']['last_name']: '';
        $chatMember['user']['username'] = isset($chatMember['user']['username']) ? $chatMember['user']['username'] : '';

        $member = Member::findOrNew($chatMember['user']['id']);
        $member->telegram_id = $chatMember['user']['id'];
        $member->telegram_name = $chatMember['user']['first_name'] . ' ' . $chatMember['user']['last_name'];
        $member->username = $chatMember['user']['username'];

        if($chatMember['role'] === 'banned') {
            $member->is_working = false;
        }
        $member->save();
        return $member;
    }

    public function updateMembers()
    {
        $bot = new Bot();
        $members = $bot->getChatMembers();
        $newMemberIds = [];

        foreach ($members as $chatMember) {
            $member = $this->_saveMember($chatMember);
            if(!$member->is_confirmed && $member->is_working) {
                $newMemberIds[] = $member->telegram_id;
            }
        }

        foreach ($newMemberIds as $memberId) {
            BotSendMessage::dispatch($memberId, Message::CODES['ENTER_BDATE']);
        }

        return $members;
    }
}
