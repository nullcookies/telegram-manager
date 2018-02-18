<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramBot extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'token'
    ];

    public function scopeByUser ($query)
    {
        $query->where('user_id', \Auth::user()->id);
    }
}
