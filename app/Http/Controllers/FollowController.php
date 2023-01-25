<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user){

        // Cant follow yourself
        if(auth()->user()->id === $user->id){
            return back()->with("error","No podés seguirte a vos mismo.");
        }

        // Cant follow someone youre already following
        $existsCheck = Follow::where([ ["user_id", "=", auth()->user()->id] , ["followeduser", "=", $user->id] ])->count();

        if($existsCheck){
            return back()->with("error","Ya seguís esta persona.");
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;

        $newFollow->save();

        return back()->with("success","Siguiendo a $user->username");
    }

    public function removeFollow(User $user){
        $follow = Follow::where([ ["user_id", "=", auth()->user()->id] , ["followeduser", "=", $user->id] ]);
        $follow->delete();

        return back()->with("success", "Dejaste de seguir a $user->username");
    }
}
