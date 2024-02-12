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
            <div class="row">
                <div class="member">
                    @foreach($data as $k => $item)
                        @if($item->on_top == \App\Models\Constant::STATUS_ACTIVE)
                            <div class="item big">
                                <img src="{{ $item->media_big ? asset($item->media_big->web_path) : null }}"/>
                                <h4 class="title">{{ optional($item->datameta('', 'name'))->data_value }}</h4>
                                <p class="position">
                                    @foreach($item->positions()->where('status', \App\Models\Constant::STATUS_ACTIVE)->get() as $position)
                                        <span>{{ optional($position->datameta('', 'name'))->data_value }}</span>
                                    @endforeach
                                </p>
                                <div class="des">
                                    <div class="des_item">
                                        {!! optional($item->datameta('', 'description-1'))->data_value !!}
                                    </div>
                                    <div class="des_item">
                                        {!! optional($item->datameta('', 'description-2'))->data_value !!}
                                    </div>
                                </div>
                                @php($hover_1 = $item->datameta('', 'hover-1'))
                                @php($hover_2 = $item->datameta('', 'hover-2'))
                                @if(!empty($hover_1) || !empty($hover_2))
                                    @if(!empty($hover_1->data_value) || !empty($hover_2->data_value))
                                        <div class="hover">
                                            @if(!empty($hover_1->data_value))
                                                <div class="des_item">
                                                    {!! $hover_1->data_value !!}
                                                </div>
                                            @endif
                                            @if(!empty($hover_2->data_value))
                                                <div class="des_item">
                                                    {!! $hover_2->data_value !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <div class="item">
                                <img src="{{ $item->media ? asset($item->media->web_path) : null }}"/>
                                <h4 class="title">{{ optional($item->datameta('', 'name'))->data_value }}</h4>
                                <p class="position">
                                    @foreach($item->positions()->where('status', \App\Models\Constant::STATUS_ACTIVE)->get() as $position)
                                        <span>{{ optional($position->datameta('', 'name'))->data_value }}</span>
                                    @endforeach
                                </p>
                                <div class="des">
                                    {!! optional($item->datameta('', 'description-1'))->data_value !!}
                                </div>
                                @php($hover_1 = $item->datameta('', 'hover-1'))
                                @if(!empty($hover_1->data_value))
                                    <div class="hover">
                                        {!! $hover_1->data_value !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
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
