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
    <div class="about">
        <div class="container">
            <div class="menu_cate">
                <p class="nav_center_T"><a data-toggle="collapse" href="#nav_center">Choose Story<span class="ic_main ar_down">&#xe036;</span></a></p>
                @if(isset($data['categories']) && !empty($data['categories']))
                    <ul class="nav navbar-nav nav_center" id="nav_center">
                        @foreach($data['categories'] as $k => $category)
                            @php
                                $flag = false;
                                $input = request()->get('category', null);

                                if (empty($input)) {
                                $flag = ($k == 0) ? true : false;
                                } else {
                                $flag = ($input == $category->id) ? true : false;
                                }
                            @endphp
                            <li @if($flag == true) class="active" @endif>
                                <a href="{{ route('front.about-us', [
                                'slug' => $post ? optional($post->datameta(env('APP_LOCALE'), 'slug'))->data_value : '404-not-found',
                                'hash_key' => $post ? optional($post->hash_key)->code : '404-not-found',
                                'category' => $category->id,
                                ]) }}">
                                    {{ optional($category->datameta('', 'name'))->data_value }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        @if(isset($data['core_value']) && !empty($data['core_value']))
            <div class="container">
                <p class="img_about">
                    @php($media = \App\Models\Media::getOneMedia(['locale' => LaravelLocalization::getCurrentLocale(), 'obj_id' => $data['core_value']->id, 'obj_type' => \App\Models\Media::OBJ_TYPE_CORE_VALUE_AVATAR]))
                    <img src="{{ !empty($media) ? asset($media->web_path) : null }}">
                </p>
                @if(isset($data['carousels']) && !empty($data['carousels']))
                    <div class="slide_about owl-carousel owl-theme">
                        @foreach($data['carousels'] as $k => $carousel)
                            <?php
                            $num = ($k + 1);
                            $num = ($num < 10) ? ("0" . $num) : $num;
                            ?>
                            <div class="item">
                                <p class="bar_num"><span class="num">{{ $num }}</span></p>
                                <div class="des">
                                    {!! optional($carousel->datameta('', 'description'))->data_value !!}
                                </div>
                                <?php
                                $hover = optional($carousel->datameta('', 'hover'))->data_value;
                                ?>
                                @if( strlen($hover) > 0 )
                                    <div class="hover">
                                        <div class="des1">
                                            {!! $hover !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="bg_grey">
                <div class="container contenttext">
                    <p style=" text-align:center;">
                        @php($media = \App\Models\Media::getOneMedia(['locale' => LaravelLocalization::getCurrentLocale(), 'obj_id' => $data['core_value']->id, 'obj_type' => \App\Models\Media::OBJ_TYPE_CORE_VALUE_FILE]))
                        <img src="{{ !empty($media) ? asset($media->web_path) : null }}">
                    </p>
                </div>
            </div>
            <div class="four_W">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="item">
                                <h4 class="color1">{{ __('validation.attributes.core-values-what') }}</h4>
                                <p>{{ optional($data['core_value']->datameta('', 'what'))->data_value }}</p>
                            </div>
                            <div class="item">
                                <h4 class="color2">{{ __('validation.attributes.core-values-who') }}</h4>
                                <p>{{ optional($data['core_value']->datameta('', 'who'))->data_value }}</p>
                            </div>
                        </div>
                        <div class="col">
                            @php($media = \App\Models\Media::getOneMedia(['locale' => LaravelLocalization::getCurrentLocale(), 'obj_id' => $data['core_value']->id, 'obj_type' => \App\Models\Media::OBJ_TYPE_CORE_VALUE_FILE_HOW]))
                            <img src="{{ !empty($media) ? asset($media->web_path) : null }}">
                        </div>
                        <div class="col">
                            <div class="item">
                                <h4 class="color3">{{ __('validation.attributes.core-values-where') }}</h4>
                                <p>{{ optional($data['core_value']->datameta('', 'where'))->data_value }}</p>
                            </div>
                            <div class="item">
                                <h4 class="color4">{{ __('validation.attributes.core-values-when') }}</h4>
                                <p>{{ optional($data['core_value']->datameta('', 'when'))->data_value }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="item end">
                                <h4 class="color5">{{ __('validation.attributes.core-values-how') }}</h4>
                                <p>{{ optional($data['core_value']->datameta('', 'how'))->data_value }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('front.layout.resize-banner')
@endsection
