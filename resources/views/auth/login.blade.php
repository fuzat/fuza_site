@extends('auth.layouts.app')

@section('title')
    {{ !empty($page_setting['title']) ? $page_setting['title'].' - '.env('APP_NAME') : env('APP_NAME') }}
@endsection

@section('content')
    @include('auth.layouts.left-section')
    <div class="login_right">
        <a href="javascript:void(0);" class="logo">
            <picture>
                <source srcset="{{ asset("front-end/images/thaco_logo_m.png") }}" media="(max-width: 480px)" />
                <source srcset="{{ asset("front-end/images/thaco_logo.png") }}" />
                <img src="{{ asset("front-end/images/thaco_logo.png") }}" width="210" height="38" alt="" />
            </picture>
        </a>
        <h1>{{ __('custom.button.sign-in') }}</h1>
        <h4>{{ __('custom.front-end.login-registered-account') }}</h4>
        <form role="form" action="" method="POST" class="login_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="main-key" value="{{ $page_setting['login-route'] }}">
            <div class="form-group input-icon">
                <input type="email" class="form-control" name="email" placeholder="{{ __('datametas.placeholder.email') }}" value="{{ old("email") }}">
                <span class="icon ic_thaco">&#xe013;</span>
                @if ($errors->has('email'))
                    <span class="help-block red"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
            <div class="form-group input-icon">
                <input type="password" class="form-control" name="password" placeholder="{{ __('datametas.placeholder.password') }}" value="{{ old('password') }}">
                <span class="icon ic_thaco">&#xe018;</span>
                @if ($errors->has('password'))
                    <span class="help-block red"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>
            <a href="javascript:void(0);" class="forgotten">{{ __('custom.button.forgot-password') }}?</a>
            <button type="submit" class="btn btn-primary">{{ __('custom.button.sign-in') }}</button>
        </form>
        <p>{{ __('custom.front-end.or-login-with') }}</p>
        <div class="bar_btn">
            <a href="{{ url('logins/facebook') }}" class="btn btn_face">
                <span class="ic_thaco">&#xe019;</span>FACEBOOK
            </a>
            <a href="{{ url('logins/linkedin') }}" class="btn btn_in">
                <span class="ic_thaco">&#xe008;</span>LINKEDIN
            </a>
        </div>
        <p class="link_register">
            {{ __('custom.front-end.if-not-account') }}
            <a href="javascript:void(0);">{{ __('custom.button.click-here') }}</a>
        </p>
    </div>
@endsection


