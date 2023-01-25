<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function register(Request $request){

        $incomingFields = $request->validate([
            "username" => ["required","min:3","max:20", Rule::unique('users','username')],
            "email" => ["required", "email", Rule::unique('users','email')],
            "password" => ["required","min:8","confirmed"] //input with same name + "_confirmation" for "confirmed" -> "password_confirmation"
        ]);

        $incomingFields["password"] = bcrypt($incomingFields["password"]);

        $user = User::create($incomingFields);
        auth()->login($user);

        return redirect('/')->with('success','¡Su cuenta se ha creado exitosamente!');
    }

    public function login(Request $request){
        
        $incomingFields = $request->validate([
            "loginusername" => ["required"],
            "loginpassword" => ["required"]
        ]);

        if (auth()->attempt(["username" => $incomingFields["loginusername"], "password" => $incomingFields["loginpassword"]])) {
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect('/')->with('error','Fallo login');
        }
    }

    public function loginAPI(Request $request){
        $incomingFields = $request->validate([
            "username" => ["required"],
            "password" => ["required"]
        ]);

        if (auth()->attempt($incomingFields)) {
            $user = User::where('username', $incomingFields['username'])->first();
            $token = $user->createToken('BlogToken')->plainTextToken;
            return $token;
        } else {
            return '';
        }

    }

    public function logout(Request $request){
        
        auth()->logout();
        return redirect("/");
    }

    public function showCorrectHomePage(){
        if (auth()->check()) {
            // return view("homepage-feed", ['posts' => auth()->user()->feedPosts()->latest()->get()]);
            return view("homepage-feed", ['posts' => auth()->user()->feedPosts()->latest()->paginate(5)]);
        } else {
            // if(Cache::has('postCount')){
            //     $postCount = Cache::get('postCount');
            // } else {
            //     $postCount = Post::count();
            //     Cache::put('postCount', $postCount, 20); // 20 seconds
            // }

            $postCount = Cache::remember('postCount', 20, function(){
                return Post::count();
            });

            return view("homepage", ['postCount' => $postCount]);
        }
                
    }
}
