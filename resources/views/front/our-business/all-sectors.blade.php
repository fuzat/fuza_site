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
                        <a href="javascript:void(0);">{{ __('datametas.web.title.our-business') }}</a>
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
            <div class="row">
                <ul class="list_sectors">
                    @foreach($data as $k => $item)
                        <li>
                            <img class="avata" src="{{ !empty($item->file) ? asset($item->file->web_path) : null }}" />
                            <a href="{{ route('front.our-business.show', [
                            'slug' => optional($item->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                            'hash_key' => optional($item->hash_key)->code,
                            ]) }}">
                                <p class="des">
                                    <span class="icon"><img src="{{ !empty($item->avatar) ? asset($item->avatar->web_path) : null }}"/></span>
                                    <span class="text">{{ optional($item->datameta())->data_value }}</span>
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('front.layout.resize-banner')
@endsection
