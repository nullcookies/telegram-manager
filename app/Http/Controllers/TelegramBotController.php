<?php

namespace App\Http\Controllers;

use App\Models\TelegramBot;
use Illuminate\Http\Request;

class TelegramBotController extends Controller
{
    public function index ()
    {
        $bots = TelegramBot::byUser()->get();
        return view('telegram-bot.index', compact('bots'));
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'token' => 'required|unique:telegram_bots,token'
        ]);

        $request->merge([
            'user_id' => \Auth::user()->id
        ]);
        $bot = TelegramBot::create($request->only('name', 'token', 'user_id'));

        if ($bot != null) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json(['success' => false]);
    }
}
