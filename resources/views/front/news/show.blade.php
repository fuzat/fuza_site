@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ mb_strtoupper(Illuminate\Support\Str::limit($page_setting['title'], 50)) }}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>
                        <a href="{{ route('front.news.index') }}">{{ __('datametas.web.title.news') }}</a>
                    </li>
                    <li class="active">{{ Illuminate\Support\Str::limit($page_setting['title'], 50) }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container">
            <div class="all_job">
                <div class="job_L">
                    <div class="block_gray">
                        <h4 class="title_block">
                            <a href="#menu_list" data-toggle="collapse" aria-expanded="false">
                                {{ __('datametas.web.categories') }}<span class="ic_main ar_down">&#xe036;</span>
                            </a>
                        </h4>
                        <ul class="menu_list" id="menu_list">
                            @foreach($categories as $id => $name)
                                <li>
                                    <a href="{{ route('front.news.index', ['category' => $id]) }}">
                                        {{ $name }}<span class="num">({{ \App\Models\News::sumJob(['category' => $id]) }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="block_gray view_web">
                        <h4 class="title_block1">{{ __('datametas.web.similar-categories') }}</h4>
                        <div class="listnew_sm">
                            @foreach($similars as $k => $similar)
                                <div class="item">
                                    <a href="{{ route('front.news.show', [
                                    'slug' => optional($similar->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                    'hash_key' => optional($similar->hash_key)->code,
                                    ]) }}" class="img">
                                        <img src="{{ !empty($similar->media_detail) ? asset($similar->media_detail->web_path) : null }}"/>
                                    </a>
                                    <div class="info">
                                        <a href="{{ route('front.news.show', [
                                        'slug' => optional($similar->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                        'hash_key' => optional($similar->hash_key)->code,
                                        ]) }}" class="title">
                                            {{ optional($similar->datameta('', 'name'))->data_value }}
                                        </a>
                                        <p class="date">
                                            <span class="ic_stavian icon">&#xe011;</span>{{ !empty($similar->public_date) ? \Carbon\Carbon::parse($similar->public_date)->format('d/m/Y') : null }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="job_R">
                    <div class="news_detail">
                        <img class="news_avata" src="{{ !empty($data->media_detail) ? asset($data->media_detail->web_path) : null }}"/>
                        <h1 class="title">{{ optional($data->datameta('', 'name'))->data_value }}</h1>
                        <p class="note">
                            <span class="icon_cate ic_stavian">&#xe008;</span>
                            <span class="text1">{{ !empty($data->category) ? optional($data->category->datameta('', 'name'))->data_value : null }}</span>
                            <span class="icon ic_stavian">&#xe011;</span>
                            <span class="text">{{ !empty($data->public_date) ? \Carbon\Carbon::parse($data->public_date)->format('d/m/Y') : null }}</span>
                            <span class="icon ic_stavian">&#xe009;</span>
                            <span class="text">{{ number_format($data->view) }}</span>
                        </p>
                        <div class="contenttext">
                            {!! optional($data->datameta('', 'content'))->data_value !!}
                        </div>
                    </div>
                    <div class="view_mobile">
                        <h4 class="title_block1">{{ __('datametas.web.similar-categories') }}</h4>
                        <div class="listnew_sm">
                            @foreach($similars as $k => $similar)
                                <div class="item">
                                    <a href="{{ route('front.news.show', [
                                    'slug' => optional($similar->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                    'hash_key' => optional($similar->hash_key)->code,
                                    ]) }}" class="img">
                                        <img src="{{ !empty($similar->media_detail) ? asset($similar->media_detail->web_path) : null }}"/>
                                    </a>
                                    <div class="info">
                                        <a href="{{ route('front.news.show', [
                                        'slug' => optional($similar->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                        'hash_key' => optional($similar->hash_key)->code,
                                        ]) }}" class="title">
                                            {{ optional($similar->datameta('', 'name'))->data_value }}
                                        </a>
                                        <p class="date">
                                            <span class="ic_stavian icon">&#xe011;</span>{{ !empty($similar->public_date) ? \Carbon\Carbon::parse($similar->public_date)->format('d/m/Y') : null }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('front.layout.resize-banner')
@endsection
