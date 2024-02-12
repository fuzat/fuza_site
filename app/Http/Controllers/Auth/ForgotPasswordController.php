<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\Models\MailBox;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        $page_setting = ['title' => __('custom.button.forgot-password'), 'forgot-password-route' => \Route::currentRouteName(),];

        $banner = Banner::query()
            ->where('status', Constant::STATUS_ACTIVE)
            ->whereHas('media', function ($query) {
                $query->where('status', Constant::STATUS_ACTIVE);
            })->first();

        $vars = ['banner', 'page_setting'];
        return view('auth.passwords.email', compact($vars));
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|exists:users,email']);

        $password = \Str::random(8);

        $user = User::where('email', $request->input('email'))->first();
        $user->password = \Hash::make($password);
        $user->save();

        MailBox::doCreate([
            'object_id' => $user->id,
            'email'     => $user->email,
            'name'      => $user->name,
            'subject'   => MailBox::_MAIL_SUBJECT[MailBox::_TYPE_FORGOT_PASSWORD],
            'type'      => MailBox::_TYPE_FORGOT_PASSWORD,
            'priority'  => MailBox::_PRIORITY_URGENT,
            'content'   => [
                'name'      => $user->name,
                'password'  => encrypt($password),
            ],
        ], 'user');

        $main_route = $request->input('main-key');
        return redirect()->route($main_route == 'admin-forgot-pw' ? 'admin-login' : 'login')->with('success', __('custom.msg.forgot-password.success'));
    }
}
