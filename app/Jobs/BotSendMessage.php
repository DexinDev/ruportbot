<?php

namespace App\Jobs;

use App\Models\Bot;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BotSendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_memberId;
    protected $_birthdayMemberId;
    protected $_expired;
    protected $_messageCode;

    /**
     * Create a new job instance.
     * @param int $memberId
     * @param int $messageCode
     * @param int $birthdayMemberId
     * @param false|string $expired
     */
    public function __construct(int $memberId, int $messageCode, int $birthdayMemberId = 0, string $expired = '')
    {
        $this->_memberId = $memberId;
        $this->_messageCode = $messageCode;
        $this->_birthdayMemberId = $birthdayMemberId;
        $this->_expired = $expired;
    }

    /**
     * Execute the job.
     *
     * @param Message $message
     * @param Bot $bot
     * @return void
     */
    public function handle(Message $message, Bot $bot)
    {
        $bot->message($this->_memberId, __("botMessages.{$this->_messageCode}"));

        $message->member_id = $this->_memberId;
        $message->message_code = $this->_messageCode;
        if($this->_expired) $message->expired_at = $this->_expired;
        if($this->_birthdayMemberId) $message->birthday_member_id = $this->_birthdayMemberId;
        $message->save();
    }
}
