@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ mb_strtoupper($page_setting['title']) }}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>
                        <a href="javascript:void(0);">{{ __('datametas.web.title.about-us') }}</a>
                    </li>
                    <li class="active">{{ $page_setting['title'] }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container">
            <div class="page_content">
                {!! optional($data->datameta('', 'content'))->data_value !!}
                @if(!empty($data->media))
                    <p>
                        <a class="btn btn-primary" href="{{ asset($data->media->full_path) }}">
                            <span class="icon ic_stavian">&#xe014;</span>{{ __('custom.button.view-compliance-policy') }}
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('front.layout.resize-banner')
@endsection
