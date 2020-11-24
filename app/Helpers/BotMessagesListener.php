<?php


namespace App\Helpers;


use App\Jobs\BotSendMessage;
use App\Models\Message;
use danog\MadelineProto\EventHandler;
use danog\MadelineProto\RPCErrorException;

class BotMessagesListener extends EventHandler
{
    /**
     * @var int|string Username or ID of bot admin
     */
    const ADMIN = "ruportbot"; // Change this

    private function _validate($text, $code) {
        $rules = [
            Message::CODES['ENTER_BDATE'] => [
                'text' => 'regex:/\d\d\.\d\d.\d\d\d\d/'
            ]
        ];

        return Validator::make(["text" => $text], $rules[$code])->validate();
    }

    private function _makeResponse($memberId, $messageText)
    {
        $lastMessage = Message::whereMemberId($memberId)->latest();
        if(!$lastMessage) {
            return BotSendMessage::dispatch($memberId, Message::CODES['NO_REQUEST']);
        }

        if(!$this->_validate($messageText, $lastMessage->message_code)) {
            return BotSendMessage::dispatch($memberId, $lastMessage->message_code);
        }
    }

    /**
     * Get peer(s) where to report errors
     *
     * @return int|string|array
     */
    public function getReportPeers()
    {
        return [self::ADMIN];
    }

    /**
     * Called on startup, can contain async calls for initialization of the bot
     *
     * @return void
     */
    public function onStart()
    {
    }

    /**
     * Handle updates from supergroups and channels
     *
     * @param array $update Update
     *
     * @return void
     */
    public function onUpdateNewChannelMessage(array $update): \Generator
    {
//        return $this->onUpdateNewMessage($update);
    }

    /**
     * Handle updates from users.
     *
     * @param array $update Update
     *
     * @return \Generator
     */
    public function onUpdateNewMessage(array $update): \Generator
    {
        if ($update['message']['_'] === 'messageEmpty' || $update['message']['out'] ?? false) {
            return;
        }

        $res = \json_encode($update, JSON_PRETTY_PRINT);

        try {
            $this->_makeResponse($update['message']['user_id'], $update['message']['message']);

            yield $this->messages->sendMessage(['peer'            => $update,
                                                'message'         => "<code>$res</code>",
                                                'reply_to_msg_id' => isset($update['message']['id']) ? $update['message']['id'] : null,
                                                'parse_mode'      => 'HTML'
            ]);
        } catch (RPCErrorException $e) {
            $this->report("Surfaced: $e");
        } catch (Exception $e) {
            if (\stripos($e->getMessage(), 'invalid constructor given') === false) {
                $this->report("Surfaced: $e");
            }
        }
    }
}
