<?php

namespace PepperTech\LaraKeycloak;

use Closure;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Support\Facades\Route;

class AuthnMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $routeName = Route::currentRouteName();
        // $queryParams = $request->query();
        // $checkKeys = ['state', 'session_state', 'code'];

        // if (count(array_intersect_key(array_flip($checkKeys), $queryParams)) === count($checkKeys)) {
        //     dd($queryParams);
        //     return $next($request);
        // } else {
        //     return Socialite::driver('keycloak')
        //         ->scopes(['profile', 'roles'])
        //         ->redirectUrl('http://localhost:3000' . $routeName)
        //         ->redirect();
        // }



        // try {
        //     Socialite::driver('keycloak')->user();
        //     // if ($routeName === 'auth/callback') {
        //     //     return $next($request);
        //     // }
        // } catch(InvalidStateException $e) {
            
        // }

        

        // if ($routeName === 'auth/callback') {
        //     $user = Socialite::driver('keycloak')->user();
        //     dd($user);
        // }
        
        // if ($routeName !== 'auth/callback') {
            
            
        //     return Socialite::driver('keycloak')
        //         ->scopes(['profile', 'roles'])
        //         // ->redirectUrl('http://localhost:3000/' . $routeName)
        //         ->redirect();
        // }



        /// WRONG

        // try {
        //     Socialite::driver('keycloak')->user();
        // } catch (InvalidStateException $e) {
        //     return Socialite::driver('keycloak')
        //         ->scopes(['profile', 'roles'])
        //         // ->redirectUrl('http://localhost:3000/' . $routeName)
        //         ->redirect();
        // }

        
        
        return $next($request);
    }
}
