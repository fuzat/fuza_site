<header class="index_header" id="header">
    @php($locale = LaravelLocalization::getCurrentLocale())
    <div class="container header_info">
        <div class="header_info_L">
            <a href="">{{ __('validation.attributes.settings-hotline') }}: {{ (isset($options) && $options['settings']) ? $options['settings']['hotline'] : null }}</a>
            <a href="">{{ __('validation.attributes.settings-email') }}: {{ optional(\App\Models\Datameta::getData(['field' => 'email', 'type' => 'settings']))->data_value }}</a>
        </div>
        <ul class="list_social">
            <li><a href="javascript:void(0);" class="icon ic_main">&#xe01b;</a></li>
            <li><a href="javascript:void(0);" class="icon ic_main">&#xe01d;</a></li>
            <li><a href="javascript:void(0);" class="icon ic_main">&#xe01e;</a></li>
            <li><a href="javascript:void(0);" class="icon ic_main">&#xe01c;</a></li>
            <li><a href="javascript:void(0);" class="icon ic_stavian">&#xe01d;</a></li>
            <li class="dropdown language">
                @php($supportedLocales = (isset($options) && $options['languages']) ? $options['languages'] : config('laravellocalization.supportedLocales'))
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    @foreach($supportedLocales as $i => $arr)
                        @if($locale == $arr['code'])
                            {{ strtoupper($arr['regional']) }}<span class="ic_arrow caret"></span>
                        @endif
                    @endforeach
                </a>
                <ul class="dropdown-menu">
                    @foreach($supportedLocales as $i => $arr)
                        <li @if($locale == $arr['code']) class="active" @endif>
                            <a href="{{ LaravelLocalization::getLocalizedURL($arr['code'], null, [], true) }}">{{ strtoupper($arr['regional']) }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
    <div class="container header_main">
        <div class="bg_header">
            <div class="header_L">
                <a href="{{ route('front.home') }}" class="logo">
                    <picture>
                        <source srcset="{{ asset('images/stavian_m.png') }}" media="(max-width: 480px)" />
                        <source srcset="{{ asset((isset($options) && $options['settings']) ? $options['settings']['logo-header'] : 'images/stavian.png') }}" />
                        <img src="{{ asset((isset($options) && $options['settings']) ? $options['settings']['logo-header'] : 'images/stavian.png') }}" width="204" height="39" alt="" />
                    </picture>
                </a>
            </div>
            <div class="header_R">
                <div class="search_home search_mobile">
                    <a class="btn_search ic_stavian">&#xe004;</a>
                    <a class="btn_close ic_main">&#xe04b;</a>
                    <div class="search_box">
                        {!! Form::open(['method' => 'GET', 'route' => ['front.search'], 'class' => 'search-form']) !!}
                        {!! Form::text('search', '', ['class' => 'search-field', 'placeholder' => __('custom.input.search-here')]) !!}
                        <button class="search-submit"><span class="ic_main ic_search">&#xe026;</span></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <button class="navbar-toggle collapsed ic_menu" type="button" data-toggle="collapse" data-target="#bg_menutop" aria-expanded="true">
                    <span class="ic_main"></span>
                </button>
                <div id="bg_menutop" class="bg_menutop navbar-collapse collapse">
                    <ul class="list_social social_mobile">
                        <li><a href="javascript:void(0);" class="icon ic_main">&#xe01b;</a></li>
                        <li><a href="javascript:void(0);" class="icon ic_main">&#xe01d;</a></li>
                        <li><a href="javascript:void(0);" class="icon ic_main">&#xe01e;</a></li>
                        <li><a href="javascript:void(0);" class="icon ic_main">&#xe01c;</a></li>
                        <li><a href="javascript:void(0);" class="icon ic_stavian">&#xe01d;</a></li>
                        <li class="dropdown language">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ strtoupper($locale) }}<span class="ic_arrow caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(array_keys(config('laravellocalization.supportedLocales')) as $value)
                                    <li @if($locale == $value) class="active" @endif>
                                        <a href="{{ LaravelLocalization::getLocalizedURL($value, null, [], true) }}">{{ strtoupper($value) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <ul class="menu">
                        @if(isset($options) && $options['header_menu'])

                            @php($active = \App\Models\Constant::STATUS_ACTIVE)

                            @foreach($options['header_menu'] as $i => $menu)

                                @if($menu->route_name == 'front.about-us')
                                    <li class="dropdown @if(isset($post_id) && !empty($post_id)) active @endif">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            {{ optional($menu->datameta('', 'name'))->data_value }}<span class="ic_arrow caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach(\App\Models\Post::getList(['menu' => $menu->id, 'ordering' => ['sorting' => 'asc']]) as $id => $name)
                                                <li @if(isset($post_id) && !empty($post_id) && $post_id == $id) class="active" @endif>
                                                    @php($temp = \App\Models\Post::query()->find($id))
                                                    <a href="{{ route($menu->route_name, [
                                                        'hash_key' => $temp ? optional($temp->hash_key)->code : '404-not-found',
                                                        'slug' => $temp ? optional($temp->datameta(env('APP_LOCALE'), 'slug'))->data_value : '404-not-found',
                                                        ]) }}">
                                                        {{ $name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @elseif($menu->route_name == 'front.our-business.index')
                                    <li class="dropdown @if(isset($business_id) && !empty($business_id) || (isset($flag) && $flag == 'all-sectors')) active @endif">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            {{ optional($menu->datameta('', 'name'))->data_value }}<span class="ic_arrow caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li @if(isset($flag) && $flag == 'all-sectors') class="active" @endif>
                                                <a href="{{ route($menu->route_name) }}">
                                                    {{ __('datametas.web.title.all-sectors') }}
                                                </a>
                                            </li>
                                            @foreach(\App\Models\Business::getList(['ordering' => ['sorting' => 'asc']]) as $id => $name)
                                                <li @if(isset($business_id) && !empty($business_id) && $business_id == $id) class="active" @endif>
                                                    @php($temp = \App\Models\Business::find($id))
                                                    <a href="{{ route('front.our-business.show', [
                                                        'hash_key' => $temp ? optional($temp->hash_key)->code : '404-not-found',
                                                        'slug' => $temp ? optional($temp->datameta(env('APP_LOCALE'), 'slug'))->data_value : '404-not-found',
                                                        ]) }}">
                                                        {{ $name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @elseif($menu->route_name == 'front.jobs.index')
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            {{ optional($menu->datameta('', 'name'))->data_value }}<span class="ic_arrow caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @php($current_route = Route::currentRouteName())
                                            <li @if($current_route == $menu->route_name) class="active" @endif>
                                                <a href="{{ route($menu->route_name) }}">
                                                    {{ __('datametas.web.title.all-jobs') }}
                                                </a>
                                            </li>
                                            <li @if($current_route == 'front.applicants.show-join-talent-community') class="active" @endif>
                                                <a href="{{ route('front.applicants.show-join-talent-community') }}">
                                                    {{ __('datametas.web.title.join-talent-community') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li @if(isset($menu_id) && !empty($menu_id) && $menu_id == $menu->id) class="active" @endif>
                                        @if(!empty($menu->route_name))
                                            <a href="{{ route($menu->route_name) }}">
                                                {{ optional($menu->datameta('', 'name'))->data_value }}
                                            </a>
                                        @else
                                            @php($post_id = optional($menu->posts()->where('status', \App\Models\Constant::STATUS_ACTIVE)->first())->id)
                                            <a href="{{ route('front.post.index', ['hash_key' => encrypt($post_id)]) }}">
                                                {{ optional($menu->datameta('', 'name'))->data_value }}
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        @endif
                        <li class="other_item">
                            <div class="search_home">
                                <a class="btn_search ic_stavian">&#xe004;</a>
                                <a class="btn_close ic_main">&#xe04b;</a>
                                <div class="search_box">
                                    {!! Form::open(['method' => 'GET', 'route' => ['front.search'], 'class' => 'search-form']) !!}
                                    {!! Form::text('search', '', ['class' => 'search-field', 'placeholder' => __('custom.input.search-here')]) !!}
                                    <button class="search-submit"><span class="ic_main ic_search">&#xe026;</span></button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
