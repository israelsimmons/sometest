<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

use Illuminate\Support\Facades\Log;

use App\Models\UserEmail;
use App\Models\User;

class CustomAuthProvider extends EloquentUserProvider
{

    /**
     * Override method for retrieving the user record corresponding to the given
     * email
     *
     * @param  array  $credentials [description]
     * @return [type]              [description]
     */
    public function retrieveByCredentials(array $credentials)
    {

        $user = UserEmail::where([
            'email'      => $credentials['email'],
            'is_default' => 1
        ])->first();

        if ($user) {

            $returnUser = User::find($user->user_id);

            return $returnUser;

        } else {

            return false;

        }
    }
}
