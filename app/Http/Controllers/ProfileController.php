<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showAvatarForm(){
        return view("avatar-form");
    }

    public function storeAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);

        $user = auth()->user();

        $filename = $user->id . "-" . uniqid() . ".jpg";

        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/' . $filename, $imgData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if($oldAvatar != '/fallback-avatar.jpg'){
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }

        return back()->with("success", "Avatar cambiado");
    }

    private function getSharedData($user){
        $currentlyFollowing = 0;

        if(auth()->check()){
            $currentlyFollowing = Follow::where([ ["user_id", "=", auth()->user()->id] , ["followeduser", "=", $user->id] ])->count();
        }

        View::share("sharedData", [
            'username' => $user->username, 
            'postsCount' => $user->posts()->count(),
            'followingCount' => $user->following()->count(),
            'followersCount' => $user->followers()->count(),
            'avatar' => $user->avatar,
            'currentlyFollowing' => $currentlyFollowing
        ]);
    }

    public function showProfile(User $user){
        $this->getSharedData($user);
        return view('profile-posts', 
        [
            'posts' => $user->posts()->latest()->get(),
        ]);
    }

    public function showProfileFollowers(User $user){
        $this->getSharedData($user);
        return view('profile-followers', 
        [
            'followers' => $user->followers()->latest()->get(),
        ]);
    }

    public function showProfileFollowing(User $user){
        $this->getSharedData($user);
        return view('profile-following', 
        [
            'following' => $user->following()->latest()->get(),
        ]);
    }

    // for SPA (single page app)

    public function showProfileRaw(User $user){
        return response()->json([
            'theHTML' => view(
                'profile-post-only', 
                ['posts' => $user->posts()->latest()->get()] 
            )->render(), 
            'docTitle' => "Perfil de $user->username"
        ]);
    }

    public function showProfileFollowersRaw(User $user){
        return response()->json([
            'theHTML' => view(
                'profile-followers-only', 
                ['followers' => $user->followers()->latest()->get()] 
            )->render(), 
            'docTitle' => "Seguidores de $user->username"
        ]);
    }

    public function showProfileFollowingRaw(User $user){
        return response()->json([
            'theHTML' => view(
                'profile-following-only', 
                ['following' => $user->following()->latest()->get()] 
            )->render(), 
            'docTitle' => "Seguidos por $user->username"
        ]);
    }
}
