<?php

namespace PepperTech\LaraKeycloak;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;


class AuthnController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('keycloak')
            ->scopes(['profile', 'roles'])
            // ->redirectUrl('http://localhost:3000/home')
            ->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('keycloak')->user();
        $decodedToken = Token::decode($user->accessTokenResponseBody['access_token'], env('KEYCLOAK_REALM_PUBLIC_KEY'));
        return get_object_vars($decodedToken);
        // return redirect('/home');
    }
}
