<?php

namespace App\Http\Controllers\Auth;

use App\Models\GithubUser;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller {
    public function redirect() {
        return Socialite::driver('github')->redirect();
    }

    public function callback() {
        $githubUser = Socialite::driver('github')->user();

        $name = $githubUser->name;
        if (empty($name)) {
            $name = $githubUser->nickname; // Use the nickname if the name is null
        }

        $githubUser = GithubUser::firstOrCreate(
            [
                'email' => $githubUser->email,
            ],
            [
                'github_id' => $githubUser->id,
                'name' => $name,
                'email' => $githubUser->email,
                'avatar' => 'avatars/default-avatar.png',
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($githubUser);
        return redirect('/dashboard');
    }
}
