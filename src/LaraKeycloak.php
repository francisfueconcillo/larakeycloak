<?php

namespace PepperTech\LaraKeycloak;

use Exception;
use Illuminate\Support\Facades\Http;

use Laravel\Socialite\Facades\Socialite;
use PepperTech\LaraKeycloak\Exceptions\UserNotFoundException;
use PepperTech\LaraKeycloak\Exceptions\TokenException;

class LaraKeycloak {
  private $config;
  private $decodedToken;
  
  public $user;
  
  public function __construct($socialiteUser) {
    $this->config = config('services')['keycloak'];
    
    $this->user = $socialiteUser;

    session([
      'token' => $socialiteUser->token,
      'refreshToken' => $socialiteUser->refreshToken
    ]); 

    $this->decodeAccessToken();
  }

  private function decodeAccessToken() {
    try {
      $this->decodedToken = Token::decode(
        $this->user->token, 
        $this->config['realm_public_key']
      );
    } catch (Exception $e) {
      throw new TokenException($e->getMessage());
    }
  }
  
  public function hasRole($role) {
    $resource = $this->config['client_id'];
    
    $resourceAccess = (array) $this->decodedToken->resource_access;
    
    if (array_key_exists($resource, $resourceAccess)) {
      $resourceValues = (array)$resourceAccess[$resource];

      return
        array_key_exists('roles', $resourceValues) && 
        in_array($role, $resourceValues['roles']);
    }
    return false;
  }  

}