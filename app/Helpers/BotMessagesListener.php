<?php


namespace App\Helpers;


use danog\MadelineProto\EventHandler;
use danog\MadelineProto\RPCErrorException;

class BotMessagesListener extends EventHandler
{
    /**
     * @var int|string Username or ID of bot admin
     */
    const ADMIN = "ruportbot"; // Change this

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
            yield $this->messages->sendMessage(['peer'            => $update,
                                                'message'         => "<code>$res</code>",
                                                'reply_to_msg_id' => isset($update['message']['id']) ? $update['message']['id'] : null,
                                                'parse_mode'      => 'HTML'
            ]);
            if (isset($update['message']['media']) && $update['message']['media']['_'] !== 'messageMediaGame') {
                yield $this->messages->sendMedia(['peer'    => $update,
                                                  'message' => $update['message']['message'],
                                                  'media'   => $update
                ]);
            }
        } catch (RPCErrorException $e) {
            $this->report("Surfaced: $e");
        } catch (Exception $e) {
            if (\stripos($e->getMessage(), 'invalid constructor given') === false) {
                $this->report("Surfaced: $e");
            }
        }
    }
}