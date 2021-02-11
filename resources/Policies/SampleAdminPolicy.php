<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PepperTech\LaraKeycloak\LaraKeycloak;
use PepperTech\LaraKeycloak\Exceptions\TokenException;

class SampleAdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->laraKeycloak = new LaraKeycloak();
    }

    public function view (User $user) 
    {
        return $this->laraKeycloak->hasRole('admin');
    }
}
