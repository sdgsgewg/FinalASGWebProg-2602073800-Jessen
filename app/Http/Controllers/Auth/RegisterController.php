<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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
    protected function redirectTo()
    {
        return '/payments';
    }

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
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Nama hanya boleh terdiri dari huruf dan spasi
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/'], // Password harus min 8 karakter, 1 angka, dan 1 karakter spesial
            'gender' => ['required', 'in:Male,Female'],
            'hobbies' => ['required', 'array', 'min:3'],
            'hobbies.*' => ['string', 'max:255'],
            'instagram_username' => ['nullable', 'url', 'regex:/^https:\/\/www\.instagram\.com\/[a-zA-Z0-9_]+$/'],
            'mobile_number' => ['required', 'digits_between:10,15'],
            'preferred_location' => ['required', 'string', 'max:255'],
        ], [
            'name.regex' => trans('auth.name_error'),
            'password.regex' => trans('auth.password_error'),
            'instagram_username.regex' => trans('auth.insta_error'),
            'mobile_number.digits' => trans('auth.mobile_error')
        ]);
    }    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Random Price between 100.000 - 125.000
        $data['registration_price'] = rand(100000, 125000);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'hobbies' => json_encode($data['hobbies']),
            'instagram_username' => $data['instagram_username'],
            'mobile_number' => $data['mobile_number'],
            'preferred_location' => $data['preferred_location'],
            'registration_price' => $data['registration_price'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        // Simpan data registration_price ke session
        $request->session()->put('user', $user);
        $request->session()->put('registration_price', $user->registration_price);

        return redirect($this->redirectPath());
    }

}
