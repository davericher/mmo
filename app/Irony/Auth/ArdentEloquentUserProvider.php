<?php namespace Irony\Auth;

use Illuminate\Auth\EloquentUserProvider;
use \Illuminate\Auth\UserInterface as UserInterface;

class ArdentEloquentUserProvider extends EloquentUserProvider {

    /**
     * @param \Illuminate\Auth\UserInterface $user
     * @param string $token
     */
    public function updateRememberToken(UserInterface $user, $token)
    {
        $user->setAttribute($user->getRememberTokenName(), $token);
        $user->forceSave();
    }

}