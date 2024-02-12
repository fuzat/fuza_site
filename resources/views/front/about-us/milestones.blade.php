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
            <div class="milestones">
                @foreach($data as $k => $item)
                    <div class="item item-{{ ($k % 4 + 1) }}">
                        <h4 class="title">
                            <span class="name">{{ __('datametas.web.phase', ['number' => ($k + 1)]) }}</span>
                            <span class="note">{{ optional($item->datameta('', 'name'))->data_value }}</span>
                        </h4>
                        <div class="img">
                            <span class="year">{{ $item->year }}</span>
                            <img src="{{ !empty($item->media) ? asset($item->media->web_path) : null }}" />
                            <div class="des">
                                {!! optional($item->datameta('', 'description'))->data_value !!}
                            </div>
                            @php($hover = optional($item->datameta('', 'hover'))->data_value)
                            @if(!empty($hover))
                                <div class="hover">
                                    {!! $hover !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('front.layout.resize-banner')
@endsection
