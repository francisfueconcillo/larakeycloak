<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LaraKeycloakController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('keycloak')
            ->scopes(['profile'])
            ->redirectUrl(config('app.url').'/auth/callback')
            ->redirect();            
    }

    public function callback(Request $request)
    {
        $socialiteUser = Socialite::driver('keycloak')
            ->scopes(['profile'])
            ->redirectUrl(config('app.url').'/auth/callback') 
            ->user();

        session([
            'token' => $socialiteUser->token,
            'refresh_token' => $socialiteUser->refreshToken
        ]); 

        /** CHANGE HERE
         *  The following code should query your Users database. 
         *  If the user exist, log them in.
         *  If the user does not exist, create a User account for them in your database and log them in.
         *  After login, they are redirected to their intended route before the refirection to Keycloak.
         */ 

        $user = User::where(['email' => $socialiteUser->getEmail()])->first();

        if($user) {
            Auth::login($user);
            return redirect()->intended();
        } else{
            $user = User::create([
                'name'          => $socialiteUser->getName(),
                'email'         => $socialiteUser->getEmail(),
                'password'      => '****',  // not nullable in User Model
            ]);

            Auth::login($user);
            return redirect()->intended();
        }
    }
}
