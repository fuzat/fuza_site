<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(auth()->check())
            return (auth()->user()->is_admin == Constant::_IS_ADMIN) ? redirect()->route('admin.dashboard') : redirect('/');

        $this->middleware('guest')->except('logout');
    }

    /**
     * Where to redirect users after login.
     *
     * @params \Illuminate\Http\Request Request
     * @params \Illuminate\Foundation\Auth\AuthenticatesUsers $user
     */
    protected function authenticated(Request $request, $user)
    {
        $main_route = $request->input('main-key');

        // existed account
        if (!$user) {
            $error = __('auth.suspended');
        } else if ( ($main_route == 'login' && $user->is_admin) || ($main_route == 'admin-login' && !$user->is_admin) ) {
            $error = __('auth.wrong_method_login');
        } else if ($user->status != Constant::STATUS_ACTIVE) {
            $error = __('auth.inactive');
        } else if (!$user->is_admin && !is_null($user->verified)) {
            $error = __('custom.msg.verify-email');
        }

        if (isset($error)) {
            $this->logout($request);
            return redirect()->route($main_route)->with("fail", $error);
        }

        return redirect($user->is_admin ? 'admin' : '/');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $page_setting = ['title' => __('custom.button.sign-in'), 'login-route' => \Route::currentRouteName()];

        $banner = Banner::query()
            ->whereHas('media', function ($query) {
                $query->where('status', Constant::STATUS_ACTIVE);
            })->where('status', Constant::STATUS_ACTIVE)->first();

        $vars = ['banner', 'page_setting'];

        if ($page_setting['login-route'] != 'admin-login')
            return view('auth.login', compact($vars));

        return view('auth.admin-login', compact($vars));
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|string|email|exists:users,email',
            'password'  => 'required|string|min:6',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        $this->guard()->logout();

        $request->session()->invalidate();

        return ($user->is_admin) ? redirect()->route('admin-login') : ($this->loggedOut($request) ?: redirect('/'));
    }

    public function redirectToProvider($social)
    {
//        return Socialite::driver($social)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($social)
    {
//        try {
//            $user = Socialite::driver($social)->user();
//        } catch (\Throwable $e) {
//            dd($e->getMessage());
//        }
//
//        $email = $user->getEmail();
//        if (!empty($email)) {
//            $account = User::where('email', $email)->first();
//            if (empty($account)) {
//                // create account
//                $prefix = User::_ATTR_USER.'-';
//                $params = [
//                    $prefix.'name' => !empty($name = $user->getName()) ? $name : $email,
//                    $prefix.'email' => $email,
//                    'status' => Constant::STATUS_ACTIVE,
//                ];
//                $account = User::doCreatingUser($params);
//            } else {
//                // existed account
//                if ($account->is_admin) {
//                    $error = __('auth.wrong_method_login');
//                } else if ($account->is_deleted) {
//                    $error = __('auth.suspended');
//                } else if ($account->status != Constant::STATUS_ACTIVE) {
//                    $error = __('auth.inactive');
//                }
//            }
//        } else {
//            $error = __('validation.email', ['attribute' => __('validation.attributes.applicants-email')]);
//        }
//        // error
//        if (isset($error)) {
//            return redirect('/login')->with('fail', $error);
//        }
//
//        auth()->login($account);
//        return redirect('/');
    }
}
