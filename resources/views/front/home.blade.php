@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    <div class="bannerfull owl-carousel owl-theme">
        @foreach($banners as $k => $banner)
            <div class="item">
                <a href="javascript:void(0);" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})"></a>
                <input type="hidden" id="mobile_banner" value="{{ asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) }}">
                <input type="hidden" id="web_banner" value="{{ asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) }}">
                <p class="title">
                    <span class="slogan_1">{{ optional($banner->datameta('', 'slogan_1'))->data_value }}</span>
                    <span class="slogan_2">{{ optional($banner->datameta('', 'slogan_2'))->data_value }}</span>
                </p>
            </div>
        @endforeach
    </div>
    <div class="bg_home">
        <div class="container">
            @if(isset($post) && $post->isNotEmpty())
                <section class="home_about">
                    @foreach($post as $item)
                        @if(str_contains(optional($item->datameta(env('APP_LOCALE', 'en'), 'slug'))->data_value, 'about'))
                            <div class="title">
                                <h3>{{ mb_strtoupper(optional($item->datameta('', 'title'))->data_value) }}</h3>
                                <p>{{ optional($item->datameta('', 'short-content'))->data_value }}</p>
                            </div>
                            <div class="content_home">
                                {!! optional($item->datameta('', 'content'))->data_value !!}
                            </div>
                            @break
                        @endif
                    @endforeach
                </section>
            @endif
        </div>

        @if(isset($businesses) && $businesses->isNotEmpty())
            <div class="container1 home_business">
                <div class="home_business_R">
                    <div class="title">
                        @if(isset($post) && $post->isNotEmpty())
                            @foreach($post as $item)
                                @if(str_contains(optional($item->datameta(env('APP_LOCALE', 'en'), 'slug'))->data_value, 'business'))
                                    <h3>{{ mb_strtoupper(optional($item->datameta('', 'title'))->data_value) }}</h3>
                                    <p>{{ optional($item->datameta('', 'short-content'))->data_value }}</p>
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <img src="{{ !empty($businesses[0]->file_home) ? asset($businesses[0]->file_home->web_path) : null }}" id="file_home" />
                    <div class="bar_btn">
                        <a href="{{ route('front.our-business.index') }}" class="btn btn-primary btn-lg" href="">{{ __('datametas.web.view-more') }}</a>
                    </div>
                </div>
                <div class="home_business_L">
                    <ul>
                        @foreach($businesses as $i => $business)
                            <li @if($i == 0) class="active" @endif>
                                <a href="javascript:void(0);" id="business_item">
                                    <input type="hidden" name="file_home" value="{{ !empty($business->file_home) ? asset($business->file_home->web_path) : null }}">
                                    <span class="icon" href="">
                                        @if($i == 0)
                                        <img src="{{ !empty($business->icon_act) ? asset($business->icon_act->web_path) : null }}" />
                                        @else
                                        <img src="{{ !empty($business->icon) ? asset($business->icon->web_path) : null }}" />
                                        @endif
                                        <input type="hidden" id="b-icon" value="{{ !empty($business->icon) ? asset($business->icon->web_path) : null }}">
                                        <input type="hidden" id="b-icon-act" value="{{ !empty($business->icon_act) ? asset($business->icon_act->web_path) : null }}">
                                    </span>
                                    <h4>{{ optional($business->datameta('', 'name'))->data_value }}</h4>
                                    <p>{{ optional($business->datameta('', 'short-desc'))->data_value }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    @if(isset($partners) && $partners->isNotEmpty())
        <section class="bg_green">
            <div class="container">
                <div class="title">
                    @if(isset($post) && $post->isNotEmpty())
                        @foreach($post as $item)
                            @if(str_contains(optional($item->datameta(env('APP_LOCALE', 'en'), 'slug'))->data_value, 'partner'))
                                <h3>{{ mb_strtoupper(optional($item->datameta('', 'title'))->data_value) }}</h3>
                                <p>{{ optional($item->datameta('', 'short-content'))->data_value }}</p>
                                @break
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="banner-cus owl-carousel">
                    @foreach($partners as $i => $partner)
                        <div class="item">
                            <a href="{{ !empty($partner->url) ? $partner->url : 'javascript:void(0);' }}" @if(!empty($partner->url)) target="_blank" @endif>
                                <img src="{{ !empty($partner->media) ? asset($partner->media->web_path) : null }}"/>
{{--                                <span class="title">{{ $partner->name }}</span>--}}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg_grey">
        <div class="container">
            <div class="image_list">
                <a href="" class="logo_hori"><img src="{{ asset('images/stavian_horizontal.png') }}" width="277" height="53" alt=""/></a>
                @if(isset($groups) && $groups->isNotEmpty())
                    <div class="slide_footer owl-carousel">
                        @foreach($groups as $group)
                            <div class="item">
                                <img src="{{ !empty($group->media) ? asset($group->media->web_path) : null }}"/>
                            </div>
                        @endforeach
                    </div>

                @endif
            </div>
        </div>
    </section>
@endsection

@section('css')
@endsection

@section('script')
    <script type="text/javascript">
        function widnowScreenWidth() {
            if ($(window).width() <= 1023) {
                $('.bannerfull').find('.item').map(function () {
                    $(this).find('a').css('background-image', 'url('+ $(this).find('#mobile_banner').val() +')');
                });
            } else {
                $('.bannerfull').find('.item').map(function () {
                    $(this).find('a').css('background-image', 'url('+ $(this).find('#web_banner').val() +')');
                });
            }
        }

        $(function () {

            $(window).trigger('resize');

            $(window).resize(function(){
                widnowScreenWidth();
            });

            $('body').on('click', '#business_item', function () {
                $('.home_business_L').find('li').removeAttr('class');

                $('.home_business_L').find('span.icon').each(function(i, item) {
                    $(this).find('img').attr('src', $(this).find('#b-icon').val())
                });

                $(this).closest('li').attr('class', 'active');
                $(this).find('img').attr('src', $(this).find('#b-icon-act').val());

                let file_home = $(this).find('input[name="file_home"]').val();
                $('#file_home').attr('src', file_home);
            });

        });
    </script>
@endsection
