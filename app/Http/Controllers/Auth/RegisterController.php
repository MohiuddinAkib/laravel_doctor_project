<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.Argument 1 passed to App\Http\Controllers\Auth\RegisterController::registered() must be an instance of Illuminate\Http\Client\Request, inst
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
        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile' => ['required', 'string', 'between:11, 14'],
                'address' => ['required', 'array', 'size:3'],
                'address.street' => ['required', 'string'],
                'address.city' => ['required', 'string'],
                'address.zip' => ['required', 'numeric'],
                'gender' => ['required', 'numeric'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'address.street.required' => 'The street field is required',
                'address.city.required' => 'The city field is required',
                'address.zip.required' => 'The zip field is required',
                'address.zip.numeric' => 'The zip field must be a number',
            ]
        );
    }

    /**
     * Create a new u$request->all()ser instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $profileData = Arr::only($request->all(), ['mobile', 'address', 'gender', 'category_id']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $user->assignRole($patientRole);
        $user->profile()->create($profileData);
    }
}