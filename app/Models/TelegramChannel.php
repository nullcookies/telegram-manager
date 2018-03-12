<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramChannel extends Model
{
    const CHANNEL_CREATED = 1; // Channel has been created
    const CHANNEL_ENABLED = 2; // Channel parsed and enabled
    const CHANNEL_DISABLED = 3; // Channel disabled by user
    const CHANNEL_NOT_FOUND = 4; // Channel not found in telegram
    const CHANNEL_ERROR = 5; // Other errors

    const MSG_CREATED = 'Добавлен';
    const MSG_ENABLED = 'Активен';
    const MSG_DISABLED = 'Отключен';
    const MSG_NOT_FOUND = 'Не найден';
    const MSG_ERROR = 'Ошибка';

    protected $fillable = [
        'user_id',
        'bot_id',
        'channel_id',
        'description',
        'status'
    ];

    public function scopeByUser ($query)
    {
        return $query->where('user_id', \Auth::user()->id);
    }

    public function getStatus()
    {
        $status = [
            self::CHANNEL_CREATED => self::MSG_CREATED,
            self::CHANNEL_ENABLED => self::MSG_ENABLED,
            self::CHANNEL_DISABLED => self::MSG_DISABLED,
            self::CHANNEL_NOT_FOUND => self::MSG_NOT_FOUND,
            self::CHANNEL_ERROR => self::MSG_ERROR
        ];

        return $status[$this->status];
    }

    public function bot()
    {
        return $this->belongsTo(TelegramBot::class)->withDefault([
            "name" => "Не назначен"
        ]);;
    }

}
