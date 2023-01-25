<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatMessage;

class ChatController extends Controller
{
    public function sendMessage(Request $request){
        $formFields = $request->validate([
            'textvalue' => 'required'
        ]);
    
        if (!trim(strip_tags($formFields['textvalue']))) {
            return response()->noContent();
        }
    
        // broadcast: laravel global method
        broadcast(new ChatMessage( ['username' => auth()->user()->username, 'textvalue' => strip_tags($request->textvalue), 'avatar' => auth()->user()->avatar]))->toOthers();
        return response()->noContent();
    }
}
