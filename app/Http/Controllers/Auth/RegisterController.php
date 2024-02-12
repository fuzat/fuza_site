<?php

namespace App\Http\Controllers\Auth;

use App\Models\Application;
use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
            'email'         => 'required|email|max:191|unique:users,email',
            'phone_number'  => 'required|digits_between:6,15',
            'password'      => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $prefix = User::_ATTR_USER.'-';

        $params = [
            $prefix.'name' => $data['email'],
            $prefix.'email' => $data['email'],
            $prefix.'phone_number' => $data['phone_number'],
            $prefix.'password' => $data['password'],
            $prefix.'verified' => sha1(time()),
            'status' => Constant::STATUS_ACTIVE,
        ];

        $user = User::doCreatingUser($params);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if (empty($user->verified))
            $this->guard()->login($user);

        return redirect('/login')->with('success', __('custom.msg.register-account.success'));
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $active = Constant::STATUS_ACTIVE;
        $position = BannerPosition::_LOGIN_REGISTER;

        $page_setting = ['title' => __('custom.button.sign-up')];

        $banner = Banner::query()->where('status', $active)
            ->whereHas('media', function ($query) use ($active) {
                $query->where('status', $active);
            })->first();

        $vars = ['banner', 'page_setting'];
        return view('auth.register', compact($vars));
    }
}
