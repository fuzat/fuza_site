@extends('front.layout.app')

@section('title', optional($data->datameta('', 'name'))->data_value)

@section('content')

    @php($locale = LaravelLocalization::getCurrentLocale())

    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ mb_strtoupper(optional($data->datameta('', 'name'))->data_value) }}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>
                        <a href="{{ route('front.our-business.index') }}">{{ __('datametas.web.title.our-business') }}</a>
                    </li>
                    <li class="active">{{ optional($data->datameta('', 'name'))->data_value }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container1">
            <div class="page_content">
                {!! optional($data->datameta('', 'content'))->data_value !!}
            </div>
        </div>
        <div class="bg_grey1">
            <div class="container content_operation">
                {!! optional($data->datameta('', 'scale-operation'))->data_value !!}
                <ul class="list_icontxt">
                    <li>
                        <a class="icon" href="javascript:void(0);">
                            <img src="{{ asset('images/demo/icon_1.png') }}" width="114" height="114" alt=""/>
                        </a>
                        <p class="des">
                            <span class="num">15+</span>
                            <span class="text">{{ __('datametas.web.scale-operation.experience') }}</span>
                        </p>
                    </li>
                    <li>
                        <a class="icon" href="javascript:void(0);">
                            <img src="{{ asset('images/demo/icon_2.png') }}" width="114" height="114" alt=""/>
                        </a>
                        <p class="des">
                            <span class="num">1.000+</span>
                            <span class="text">{{ __('datametas.web.scale-operation.high-employee') }}</span>
                        </p>
                    </li>
                    <li>
                        <a class="icon" href="javascript:void(0);">
                            <img src="{{ asset('images/demo/icon_3.png') }}" width="114" height="114" alt=""/>
                        </a>
                        <p class="des">
                            <span class="num">80+</span>
                            <span class="text">{{ __('datametas.web.scale-operation.country-around-world') }}</span>
                        </p>
                    </li>
                </ul>
            </div>
        </div>

        @php($development_strategy = optional($data->datameta($locale, 'development-strategy'))->data_value)
        @if( strlen($development_strategy) > 0 )
            <div class="bg_blue" style="background-image:url({{ asset('images/demo/dev1.jpg') }}) ">
                <div class="container">
                    <div class="contenttext">
                        {!! optional($data->datameta($locale, 'development-strategy'))->data_value !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="cate_link" style="background: url({{ !empty($data->products_background) ? asset($data->products_background->web_path) : null }})">
            <div class="container1">
                <div class="title_product">
                    {!! optional($data->datameta($locale, 'our-products'))->data_value !!}
                    <p>
                        <a class="btn btn-primary" href="{{ !empty($data->all_products_url) ? $data->all_products_url : 'javascript:void(0);' }}" @if(!empty($data->all_products_url)) target="_blank" @endif>
                            {{ __('custom.button.view-all-products') }}<span class="icon ic_stavian">&#xe00b;</span>
                        </a>
                    </p>
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
