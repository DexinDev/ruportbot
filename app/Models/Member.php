<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member
 *
 * @property int $telegram_id
 * @property string|null $name
 * @property string|null $username
 * @property bool $isConfirmed
 * @property string|null $dateOfBirth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIsConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUsername($value)
 * @mixin \Eloquent
 * @property string|null $telegram_name
 * @property bool|null $wantPresents
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereTelegramName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereWantPresents($value)
 * @property bool $is_confirmed
 * @property string|null $date_of_birth
 * @property bool|null $want_presents
 * @property bool $is_working
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIsWorking($value)
 */
class Member extends Model
{
    use HasFactory;
    protected $primaryKey = 'telegram_id';
}
