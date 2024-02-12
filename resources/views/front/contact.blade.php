@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ $page_setting['title'] }}</h1>
                <ol class="breadcrumb">
                    <li class="active"><a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>{{ $page_setting['title'] }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container">
            <div class="contact_page">
                @if(!empty($post))
                    {!! str_replace('<ul>', '<ul class="contact_list">', optional($post->datameta('', 'content'))->data_value) !!}
                @endif
                <h4>{{ __('datametas.web.contact.please-contact-us') }}</h4>
                {!! Form::open(['method' => 'POST', 'route' => ['front.contact.store'], 'class' => 'form_sendinfo']) !!}
                <div class="form-group">
                    {!! Form::label('fullname', __('datametas.web.contact.label.name')) !!}
                    {!! Form::text('fullname', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone', __('datametas.web.contact.label.phone-number')) !!}
                    {!! Form::text('phone', '', ['class' => 'form-control', 'placeholder' => __('datametas.web.contact.placeholder.phone-number')]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', __('datametas.web.contact.label.email')) !!}
                    {!! Form::text('email', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('subject', __('datametas.web.contact.label.subject')) !!}
                    {!! Form::text('subject', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('message', __('datametas.web.contact.label.message')) !!}
                    {!! Form::textarea('message', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('industry', __('datametas.web.contact.label.industry')) !!}
                    {!! Form::select('industry', $industries, '', ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
                <div class="form-group bar_btn">
                    <button type="submit" class="btn btn-primary btn-lg btn-send-contact">
                        {{ __('datametas.web.contact.button.send-message') }} <span class="icon ic_stavian">&#xe014;</span>
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('script')
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('.form_sendinfo').submit(function (e) {
                e.preventDefault();

                $.blockUI({message: ''});

                var data = $(this).serialize();

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: data,
                    error: function(data){
                        Swal.fire({
                            type: 'error',
                            title: 'Network Error',
                        }).then(function (okay) {
                            if(okay)
                                return window.location.reload(true);
                        });
                    },
                }).done(function(resp){ //
                    Swal.fire({
                        type: (resp.code == 200) ? 'success' : 'error',
                        title: resp.msg,
                    }).then(function (okay) {
                        if(okay) {
                            if (resp.code == 200)
                                return window.location.reload(true);
                        }
                    });

                    $.unblockUI();
                });
            });
        });
    </script>
    @include('front.layout.resize-banner')
@endsection
