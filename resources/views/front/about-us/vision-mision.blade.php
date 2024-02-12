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
            <div class="vision_page">
                @if($data->isNotEmpty())
                    <ul class="about_list">
                        @foreach($data as $k => $item)
                            <li>
                                <img class="icon" src="{{ !empty($item->icon_inactive) ? asset($item->icon_inactive->web_path) : null }}">
                                {{ optional($item->datameta('', 'content'))->data_value }}
                                <input type="hidden" id="icon_inactive" value="{{ !empty($item->icon_inactive) ? asset($item->icon_inactive->web_path) : null }}">
                                <input type="hidden" id="icon_active" value="{{ !empty($item->icon_active) ? asset($item->icon_active->web_path) : null }}">
                            </li>
                        @endforeach
                    </ul>
                @endif
                <img class="img_avata" src="{{ !empty($post->media_vision_mission) ? asset($post->media_vision_mission->web_path) : null }}" width="570" height="517" alt=""/>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('front.layout.resize-banner')
    <script type="text/javascript">
        $(function () {
            $('.about_list').on('mouseover', 'li', function () {
                $('.about_list').find('li').each(function () {
                    $(this).find('img').attr('src', $(this).find('#icon_inactive').val());
                });

                $(this).find('img').attr('src', $(this).find('#icon_active').val());
            });

            $('.vision_page').on('mouseout', '.about_list', function () {
                $(this).find('li').each(function () {
                    $(this).find('img').attr('src', $(this).find('#icon_inactive').val());
                });
            });
        });
    </script>
@endsection
