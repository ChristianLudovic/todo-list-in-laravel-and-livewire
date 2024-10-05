<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();;
    }

    public function handleProviderCallback($provider)
    {
        
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::updateOrCreate([
            'email' => $socialUser->getEmail(),
        ], [
            'name' => $socialUser->getName(),
            'password' => bcrypt(Str::random(16)),
            $provider . '_id' => $socialUser->getId(),
            'image' => $socialUser->getAvatar(),
        ]);

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }

}