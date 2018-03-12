<?php

namespace App\Http\Controllers;

use App\Models\TelegramChannel;
use Illuminate\Http\Request;

class TelegramChannelController extends Controller
{
    public function index ()
    {
        $channels = TelegramChannel::byUser()->get();

        return view('telegram-channel.index', compact('channels'));
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'channel_id' => 'required|min:3|unique:telegram_channels'
        ], $this->messages());

        TelegramChannel::create([
            'user_id' => \Auth::user()->id,
            'channel_id' => $request->channel_id
        ]);

        return response()->json([
            'message' => 'Канал добавлен. После обработки он появится в списке.'
        ], 201);
    }

    public function messages()
    {
        return [
            'channel_id.required' => 'ID канала должно быть заполнено',
            'channel_id.min' => 'Минимальная длинна идентификатора - 3 символа',
            'channel_id.unique' => 'Канал с таким идентификатором уже добавлен'
        ];
    }
}

