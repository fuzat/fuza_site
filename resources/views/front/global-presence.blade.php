@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ $page_setting['title'] }}</h1>
                <ol class="breadcrumb">
                    <li class="active"><a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>{{ $page_setting['title'] }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container">
            <div class="map">
                <img src="{{ asset('images/map.png') }}" width="1200" height="593" alt=""/>
            </div>
            @foreach($data as $k => $item)
                @if($item->headquarter == \App\Models\Constant::STATUS_ACTIVE)
                    <div class="box_grey">
                        <h4>{{ mb_strtoupper(optional($item->datameta('', 'name'))->data_value) }}</h4>
                        <p>{{ optional($item->datameta('', 'address'))->data_value }}</p>
                        <p>
                            <span class="ic_stavian">&#xe000;</span>
                            <span class="text">{{ $item->phone }}</span>
                            <span class="ic_stavian">&#xe007;</span>
                            <span class="text">{{ $item->email }}</span>
                        </p>
                    </div>
                @endif
            @endforeach

            <div class="sort_bar">
                <span class="text">Field order</span>
                <select class="form-control" id="sort">
                    <option value="">{{ __('custom.button.sort') }}</option>
                    @foreach(trans('datametas.select-box.sort') as $key => $value)
                        <option value="{{ $key }}" @if($sort == $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="global">
                @foreach($data as $k => $item)
                    @if($item->headquarter == \App\Models\Constant::STATUS_INACTIVE)
                        <div class="box_grey">
                            <h4>{{ mb_strtoupper(optional($item->datameta('', 'name'))->data_value) }}</h4>
                            <p>{{ optional($item->datameta('', 'address'))->data_value }}</p>
                            <p>
                                <span class="ic_stavian">&#xe000;</span>
                                <span class="text">{{ $item->phone }}</span>
                                <span class="ic_stavian">&#xe007;</span>
                                <span class="text">{{ $item->email }}</span>
                            </p>
                        </div>
                    @endif
                @endforeach
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
            $('#sort').on('change', function (e) {
                e.preventDefault();
                window.location.replace(route('front.global-presence', {ordering: $(this).val()}), true);
            });
        });
    </script>
@endsection
