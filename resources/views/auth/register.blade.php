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
        <h1>{{ __('custom.button.sign-up') }}</h1>
        <h4>{{ __('custom.front-end.register-account') }}</h4>
        <form role="form" action="{{ route('register') }}" method="POST" class="login_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group input-icon">
                <input type="email" class="form-control" name="email" placeholder="{{ __('datametas.placeholder.email') }}" value="{{ old('email') }}">
                <span class="icon ic_thaco">&#xe013;</span>
                @if ($errors->has('email'))
                    <span class="help-block" style="color: red;"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
            <div class="form-group input-icon">
                <input type="text" class="form-control" name="phone_number" placeholder="{{ __('custom.placeholder.enter-phone-number') }}" value="{{ old('phone_number') }}">
                <span class="icon ic_thaco phone">&#xe014;</span>
                @if ($errors->has('phone_number'))
                    <span class="help-block" style="color: red;"><strong>{{ $errors->first('phone_number') }}</strong></span>
                @endif
            </div>
            <div class="form-group input-icon">
                <input type="password" class="form-control" name="password" placeholder="{{ __('custom.placeholder.enter-password') }}" value="{{ old('password') }}">
                <span class="icon ic_thaco">&#xe018;</span>
                @if ($errors->has('password'))
                    <span class="help-block" style="color: red;"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>
            <div class="form-group input-icon">
                <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('custom.placeholder.confirmed-password') }}" value="{{ old('password_confirmation') }}">
                <span class="icon ic_thaco">&#xe018;</span>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block" style="color: red;"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                @endif
            </div>
            <a href="" class="forgotten"></a>
            <button type="submit" class="btn btn-primary">{{ __('custom.button.sign-up') }}</button>
        </form>
    </div>
@endsection


