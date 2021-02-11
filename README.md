# LaraKeycloak
---
- [Overview](#overview)
- [Features](#features)
- [Keycloak Configurations](#keycloak-configure)
- [Installation](#install)
- [Configuration](#config)
- [Integration](#integrate)
- [Testing](#testing)

<a name="overview"></a>
## Overview
LaraKeycloak provides Authentication using [KeyCloak Socialite Provider](https://socialiteproviders.com/Keycloak/) and RBAC Authorization by checking user roles from [Keycloak](https://www.keycloak.org). 

<a name="features"></a>
## Features
- Provides Authentication using [KeyCloak Socialite Provider](https://socialiteproviders.com/Keycloak/)
- Provides Authorization by RBAC managed by KeyCloak

<a name="keycloak-configure"></a>
## Keycloak Configurations
Before installing LaraKeycloak, configure your Keycloak Server to add your application as Client. 
### Creating a Keycloak Client
<a href="./keycloak-client.png" target="_blank"><img src="./keycloak-client.png" alt="Client" width="250"/></a>

### Add User Roles in Keycloak Client
<a href="./client-roles.png" target="_blank"><img src="./client-roles.png" alt="Roles" width="250"/></a>

### Create Users and Assign Roles
Create at least a Regular User and an Admin User, for testing Authorization later on.

<a href="./user-roles.png" target="_blank"><img src="./user-roles.png" alt="Roles" width="250"/></a>


<a name="install"></a>
## Installation
```
composer require peppertech/larakeycloak
```

<a name="configure"></a>
## Configuration
### Environment Variables
Variable | Required | Description | Default Value
--- | --- | --- | ---
KEYCLOAK_BASE_URL | Yes | Keycloak Server URL. ie. https://[keycloak server]/auth | none |
KEYCLOAK_REALMS | Yes | Keycloak Realm | none |
KEYCLOAK_CLIENT_ID | Yes | Keycloak Client ID | none |
KEYCLOAK_CLIENT_SECRET | Yes | OpenId Connect Client Secret | none |
KEYCLOAK_REDIRECT_URI | Yes | The default page to redirect users after login | /home |
KEYCLOAK_REALM_PUBLIC_KEY | Yes | Keycloak Realm RS256 Public Key | none |

<a name="integrate"></a>
## Integration

### Published Files
Run the following commands to publish the files to your app.
```
php artisan vendor:publish --tag="larakeycloak"
```
This will copy the following files:
- `app/Http/Controllers/LaraKeyController.php`, controller for the `/auth/redirect` and '/auth/callback` routes.
- `app/Policies/SampleAdminPolicy.php`, an example Admin Policy to secure certain pages in your application for `admin` role
- `resources/views/sample_admin_blade.php`, example Admin View with `/sample/admin` route.
- `app/Http/Controllers/SampleAdminController.php`, controller for the `/sample/admin` route.

### Routes
Create the following routes in your `app/routes/web.php`
```
Route::group(['middleware' => ['auth:web']], function () {
    ...
    Route::get('/sample/admin', 'SampleAdminController@index')->name('sample-admin');
});

Route::get('/auth/redirect', 'LaraKeycloakController@redirect')->name('auth-redirect');
Route::get('/auth/callback', 'LaraKeycloakController@callback')->name('auth-callback');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
```

Add the following `logout` method in your `LoginController`
```
use Illuminate\Support\Facades\Auth;
use PepperTech\LaraKeycloak\LaraKeycloak;

....
public function logout()
{
    $larakc = new LaraKeyCloak();
    $larakc->logout();
    Auth::guard('web')->logout();
    return redirect()->guest(route('main'));   // `main` is the route name of public homepage
}
```

### Auth Middleware


### Gates



###
<a name="authz"></a>
## Authorization


<a name="testing"></a>
## Testing






