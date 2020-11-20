<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $message_code
 * @property int $member_id
 * @property int $birthday_member_id
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereBirthdayMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Message extends Model
{
    const CODES = [
        'ENTER_BDATE' => 0,
        'ENTER_NAME' => 1,
        'ENTER_PRESENT_SUM' => 2,
    ];

    public function member() {
        return $this->hasOne('App\Models\Member', 'telegram_id', 'member_id');
    }

    public function birthDayDude() {
        return $this->hasOne('App\Models\Member', 'telegram_id', 'birthday_member_id');
    }
}
