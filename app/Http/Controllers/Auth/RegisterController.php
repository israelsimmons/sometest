<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user_emails',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * For this test the user information and the emails are in different tables
     * we need to save the email
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = false;

        try {
            // We open a transaction so the data is always consistend even if
            // an error happens
            DB::beginTransaction();

            // Store information in the users table
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'password'   => Hash::make($data['password']),
            ]);

            // as this is the very first registration of an user we need to
            // set the field 'is_default' = 1 so the user can actually sign in
            // into the app later on

            $user->emails()->create(
                [
                    'email' =>$data['email'],
                    'is_default' => 1
                ]
            );

            // Another way to store the same record as the above piece of code
            // UserEmail::create(
            //     [
            //         'user_id'    => $user->id,
            //         'email'      => $data['email'],
            //         'is_default' => 1
            //     ]
            // );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $user;
    }
}
