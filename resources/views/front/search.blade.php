@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container"><div class="inside_title"></div></div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container">
            <div class="search_page">
                <h1>{{ mb_strtoupper($page_setting['title']) }}</h1>
                <div class="search_full">
                    {!! Form::open(['method' => 'GET', 'route' => ['front.search']]) !!}
                    {!! Form::text('search', isset($search['search']) ? $search['search'] : '', ['class' => 'form-control box-placeholder', 'placeholder' => __('custom.input.search-here'), 'id' => 'search']) !!}
                    <button class="btn btn-primary" id="btn-search">
                        <span class="btn_search ic_stavian">&#xe004;</span>{{ __('custom.button.search') }}
                    </button>
                    {!! Form::close() !!}
                </div>
                <p class="note">
                    @if(($total = $data->total()) > 0)
                        {{ __('datametas.web.total-results-found', ['total' => $total == 1 ? $total . ' result' : $total . ' results']) }}
                    @endif
                </p>
                <div class="row search_list">
                    @foreach($data as $k => $item)
                        <div class="item">
                            @if($item->obj_type == \App\Models\SearchResult::_OBJ_TYPE_JOB)
                                <a href="{{ route('front.jobs.show', [
                                'slug' => Illuminate\Support\Str::slug(optional($item->job->datameta(env('APP_LOCALE'), 'name'))->data_value),
                                'hash_key' => optional($item->job->hash_key)->code,
                                ]) }}" class="img" style="background-image: url('{{ !empty($item->job->media) ? asset($item->job->media->web_path) : null }}')">
                                </a>
                                <div class="info">
                                    <a href="{{ route('front.jobs.index') }}" class="title">
                                        {{ __('datametas.web.title.careers') }}
                                    </a>
                                    <a href="{{ route('front.jobs.show', [
                                    'slug' => Illuminate\Support\Str::slug(optional($item->job->datameta(env('APP_LOCALE'), 'name'))->data_value),
                                    'hash_key' => optional($item->job->hash_key)->code,
                                    ]) }}" class="des">
                                        {{ Illuminate\Support\Str::limit(optional($item->job->datameta('', 'name'))->data_value, 60, '...') }}
                                    </a>
                                </div>
                            @elseif($item->obj_type == \App\Models\SearchResult::_OBJ_TYPE_NEWS)
                                <a href="{{ route('front.news.show', [
                                'slug' => optional($item->news->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                'hash_key' => optional($item->news->hash_key)->code,
                                ]) }}" class="img" style="background-image: url('{{ !empty($item->news->media_detail) ? asset($item->news->media_detail->web_path) : null }}')">
                                </a>
                                <div class="info">
                                    <a href="{{ route('front.news.index') }}" class="title">
                                        {{ __('datametas.web.title.news') }}
                                    </a>
                                    <a href="{{ route('front.news.show', [
                                    'slug' => optional($item->news->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                    'hash_key' => optional($item->news->hash_key)->code,
                                    ]) }}" class="des">
                                        {{ Illuminate\Support\Str::limit(optional($item->news->datameta('', 'name'))->data_value, 60, '...') }}
                                    </a>
                                </div>
                            @elseif($item->obj_type == \App\Models\SearchResult::_OBJ_TYPE_BUSINESS)
                                <a href="{{ route('front.our-business.show', [
                                'slug' => optional($item->business->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                'hash_key' => optional($item->business->hash_key)->code,
                                ]) }}" class="img" style="background-image: url('{{ !empty($item->business->file) ? asset($item->business->file->web_path) : null }}')">
                                </a>
                                <div class="info">
                                    <a href="{{ route('front.our-business.index') }}" class="title">
                                        {{ __('datametas.web.title.our-business') }}
                                    </a>
                                    <a href="{{ route('front.our-business.show', [
                                    'slug' => optional($item->business->datameta(env('APP_LOCALE'), 'slug'))->data_value,
                                    'hash_key' => optional($item->business->hash_key)->code,
                                    ]) }}" class="des">
                                        {{ Illuminate\Support\Str::limit(optional($item->business->datameta('', 'name'))->data_value, 60, '...') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="pagination_jobs">
                    {!! $data->appends($search)->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#btn-search').click(function (e) {
                e.preventDefault();
                window.location.replace(route('front.search', {search: $('#search').val()}), true);
            });
        });
    </script>
    @include('front.layout.resize-banner')
@endsection
