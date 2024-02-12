@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ mb_strtoupper($page_setting['title']) }}</h1>
                <ol class="breadcrumb">
                    <li class="active"><a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>{{ $page_setting['title'] }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="container">
        <div class="menu_cate">
            <p class="nav_center_T"><a data-toggle="collapse" href="#nav_center">Choose Story<span class="ic_main ar_down">&#xe036;</span></a></p>
            @if(!empty($categories))
                <ul class="nav navbar-nav nav_center" id="nav_center">
                    @foreach($categories as $id => $name)
                        @if(isset($params['category']) && !empty($params['category']))
                            <li @if($id == $params['category']) class="active" @endif>
                                <a href="{{ route('front.news.index', ['category' => $id]) }}">{{ $name }}</a>
                            </li>
                        @else
                            <li @if($id == array_key_first($categories)) class="active" @endif>
                                <a href="{{ route('front.news.index', ['category' => $id]) }}">{{ $name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="news_highlight">
            @foreach($hot_news as $k => $item)
                <div class="item @if($k == 0) big @else sm @endif">
                    <a href="{{ route('front.news.show', [
                    'slug' => optional($item->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                    'hash_key' => optional($item->hash_key)->code,
                    ]) }}" class="img">
                        @if($k == 0)
                            <img src="{{ !empty($item->media_big) ? asset($item->media_big->web_path) : null }}"/>
                        @else
                            <img src="{{ !empty($item->carousel) ? asset($item->carousel->web_path) : null }}"/>
                        @endif
                    </a>
                    <div class="info">
                        <a href="{{ route('front.news.show', [
                        'slug' => optional($item->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                        'hash_key' => optional($item->hash_key)->code,
                        ]) }}" class="title">
                            {{ Illuminate\Support\Str::limit(optional($item->datameta('', 'name'))->data_value, 60, '...') }}
                        </a>
                        <p class="date">
                            <span class="ic_stavian icon">&#xe011;</span>{{ !empty($item->public_date) ? \Carbon\Carbon::parse($item->public_date)->format('d/m/Y') : null }}
                        </p>
                        @if(!empty($item->video))
                            <a href="#" data-toggle="modal" data-target="#uploadCV" id="video">
                                <span class="ic_play ic_stavian">&#xe017;</span>
                                <input type="hidden" name="video" value="{{ asset($item->video->full_path) }}">
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="listnew">
            @foreach($data as $k => $item)
                <div class="item">
                    <a href="{{ route('front.news.show', [
                    'slug' => optional($item->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                    'hash_key' => optional($item->hash_key)->code,
                    ]) }}" class="img">
                        <img src="{{ !empty($item->media_detail) ? asset($item->media_detail->web_path) : null }}"/>
                    </a>
                    <div class="info">
                        <a href="{{ route('front.news.show', [
                        'slug' => optional($item->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                        'hash_key' => optional($item->hash_key)->code,
                        ]) }}" class="title">
                            {{ Illuminate\Support\Str::limit(optional($item->datameta('', 'name'))->data_value, 60, '...') }}
                        </a>
                        <p class="date">
                            <span class="ic_stavian icon">&#xe011;</span>{{ !empty($item->public_date) ? \Carbon\Carbon::parse($item->public_date)->format('d/m/Y') : null }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination_jobs">
            {!! $data->appends($params)->links() !!}
        </div>
    </div>

    <div class="modal fade" id="uploadCV" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="ic_main">&#xe04b;</span></button>
                </div>
                <div class="modal-body pop_info">
                    <video width="100%" height="auto" controls>
                    </video>
                </div>
                <div class="modal-footer">
                    <div class="pop_btn" role="group" aria-label="group button">
                        <button type="button" class="btn btn-default close" data-dismiss="modal" role="button">
                            {{ __('custom.button.cancel') }}
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    <script>
        $('a#video').on('click', function () {
            var video = $(this).find('input[name=video]').val();
            $('#uploadCV').find('video').attr('src', video);
        });

        $('#uploadCV').on('click', '.close',function () {
            $('#uploadCV').find('video').attr('src', '');
        });
    </script>
    @include('front.layout.resize-banner')
@endsection
