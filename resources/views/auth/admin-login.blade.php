@extends('auth.layouts.app')

@section('title')
    {{ !empty($page_setting['title']) ? $page_setting['title'].' - '.env('APP_NAME') : env('APP_NAME') }}
@endsection

@section('content')
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{ asset('assets/app/media/img//bg/bg-3.jpg') }});">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="javascript:void(0);">
                            <img src="{{ asset('images/STV_Logo-group.png') }}">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        {!! Form::open(['method' => 'POST', 'route' => ['login'], 'class' => 'm-login__form m-form']) !!}
                        <input type="hidden" name="main-key" value="{{ $page_setting['login-route'] }}">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="{{ __('datametas.placeholder.email') }}" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <div class="form-control-feedback text-danger"><strong>{{ $errors->first('email') }}</strong></div>
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="{{ __('datametas.placeholder.password') }}" name="password" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <div class="form-control-feedback text-danger"><strong>{{ $errors->first('password') }}</strong></div>
                            @endif
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Sign In
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


