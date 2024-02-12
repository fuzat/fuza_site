@extends('auth.layouts.app')

@section('title')
    {{ !empty($page_setting['title']) ? $page_setting['title'].' - '.env('APP_NAME') : env('APP_NAME') }}
@endsection

@section('content')
    @include('auth.layouts.left-section')
    <div class="login_right">
        <a href="{{ route("front.home") }}" class="logo">
            <picture>
                <source srcset="{{ asset("front-end/images/thaco_logo_m.png") }}" media="(max-width: 480px)" />
                <source srcset="{{ asset("front-end/images/thaco_logo.png") }}" />
                <img src="{{ asset("front-end/images/thaco_logo.png") }}" width="210" height="38" alt="" />
            </picture>
        </a>
        <h1>{{ __('custom.button.forgot-password') }}</h1>
        <form role="form" action="{{ route('password.email') }}" method="POST" class="login_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="main-key" value="{{ $page_setting['forgot-password-route'] }}">
            <div class="form-group input-icon">
                <input type="email" class="form-control" name="email" placeholder="{{ __('datametas.placeholder.email') }}" value="{{ old("email") }}">
                <span class="icon ic_thaco">&#xe013;</span>
                @if ($errors->has('email'))
                    <span class="help-block red"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">{{ __('custom.button.send') }}</button>
            <a href="{{ $page_setting['forgot-password-route'] == 'admin-forgot-pw' ? route('admin-login') : route('login') }}" class="forgotten">{{ __('custom.button.sign-in') }}</a>
        </form>
    </div>
@endsection
