<?php


namespace App\Models;


use danog\MadelineProto\API;

class Bot
{
    private $_madeline;

    function __construct($madeline = false)
    {
        if ($madeline) {
            $this->_madeline = $madeline;
        } else {
            $this->_madeline = new API('session.new');
        }
    }

    public function auth()
    {
        $statuses = [];
        $statuses[] = $this->_madeline->start();
        $statuses[] = $this->_madeline->getSelf();
        return $statuses;
    }

    public function getChatMembers()
    {
        $chat = [
            '_'          => 'peerChannel',
            'channel_id' => getenv('TELEGRAM_CHAT_ID'),
        ];

        $chatInfo = $this->_madeline->getPwrChat($chat);

        return $chatInfo['participants'];
    }

    public function message($peerId, $text)
    {
        $this->_madeline->messages->sendMessage(['peer' => $peerId, 'message' => $text]);
    }
}
