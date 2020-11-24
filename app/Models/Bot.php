<?php


namespace App\Models;


use danog\MadelineProto\API;

class Bot
{
    private $_madeline;

    function __construct()
    {
        $this->_madeline = new API('session.new');
    }

    public function auth()
    {
        $this->_madeline->start();
        return $this->_madeline->getSelf();
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
