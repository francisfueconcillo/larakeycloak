<?php

namespace PepperTech\LaraKeycloak;

use Illuminate\Support\Facades\Http;
use Firebase\JWT\ExpiredException;
use Laravel\Socialite\Facades\Socialite;
use PepperTech\LaraKeycloak\Exceptions\UserNotFoundException;
use PepperTech\LaraKeycloak\Exceptions\TokenException;
use PepperTech\LaraKeycloak\Exceptions\LogoutException;

class LaraKeycloak 
{
  private $config;
  private $decodedToken;
  public $userRoles;

  public function __construct() {
    $this->config = config('services.keycloak');
    $this->userRoles = $this->getRoles();
  }

  private function getRoles() 
  {
    $resource = $this->config['client_id'];    

    try {
      $this->decodedToken = $this->getDecodedToken();
      $resourceAccess = (array) $this->decodedToken->resource_access;

      if (array_key_exists($resource, $resourceAccess)) {
        $resourceValues = (array) $resourceAccess[$resource];

        if(array_key_exists('roles', $resourceValues)) {
          return $resourceValues['roles'];
        }
      }

    } catch(\Exception $e) {
      return [];
    }
    
    return [];
  }

  private function getDecodedToken() 
  {
    $token = session('token');
    
    try {
      return Token::decode($token, $this->config['realm_public_key']);
    } catch(ExpiredException $e) {
      $this->refreshToken();
    } catch (\Exception $e) {
      return redirect()->route('auth-redirect');
    }
  }
  
  private function refreshToken() 
  {
    $url =  $this->config['base_url'].
            '/realms/'.$this->config['realms'].'/protocol/openid-connect/token';

    $params = [
      'client_id' => $this->config['client_id'],
      'client_secret' => $this->config['client_secret'],
      'grant_type' => 'refresh_token',
      'refresh_token' => session('refresh_token'),
    ];
    try {
      $response = Http::asForm()->post($url, $params);
      
      session([
        'token' => $response['access_token'],
        'refresh_token' => $response['refresh_token']
      ]);
      $this->decodedToken = $this->getDecodedToken();

    } catch(\Exception $e) {
      return redirect()->route('auth-redirect');
    }
  }

  
  public function hasRole($role) 
  {
    return in_array($role, $this->userRoles);
  } 
  
  public function logout() 
  {
    $url =  $this->config['base_url'].
            '/realms/'.$this->config['realms'].'/protocol/openid-connect/logout';

    $params = [
      'client_id' => $this->config['client_id'],
      'client_secret' => $this->config['client_secret'],
      'refresh_token' => session('refresh_token'),
    ];

    try {
      $response = Http::asForm()->post($url, $params);
      
      session([
        'token' => null,
        'refresh_token' => null
      ]);
      $this->decodedToken = null;

    } catch(\Exception $e) {
      throw new LogoutException($e->getMessage());
    }
  } 
}