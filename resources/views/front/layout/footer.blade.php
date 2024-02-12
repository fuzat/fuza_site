<footer class="index_footer">
    <div class="container">
        <div class="row">
            <div class="footer_item1 info_company">
                <a href="" class="logo_footer">
                    <img src="{{ asset((isset($options) && $options['settings']) ? $options['settings']['logo-footer'] : 'images/logo_footer.png') }}" width="262" height="163" alt=""/>
                </a>
                <p>{{ (isset($options) && !empty($options['settings'])) ? optional(\App\Models\Datameta::getData(['type' => 'settings', 'field' => 'logo-footer-text'], LaravelLocalization::getCurrentLocale()))->data_value : null }}</p>
            </div>
            <div class="footer_item">
                <h4>{{ __('datametas.web.footer.contact') }}</h4>
                <ul class="list_icontxtV">
                    @if(isset($options) && isset($options['settings']))
                        <li>
                            <a class="des">
                                <span class="icon ic_stavian" >&#xe018;</span>{{ optional(\App\Models\Datameta::getData(['field' => 'address', 'type' => 'settings']))->data_value }}
                            </a>
                        </li>
                        <li>
                            <a class="des">
                                <span class="icon ic_stavian" >&#xe000;</span>{{ $options['settings']['hotline'] }}
                            </a>
                        </li>
                        <li>
                            <a class="des">
                                <span class="icon ic_stavian" >&#xe019;</span>{{ $options['settings']['fax'] }}
                            </a>
                        </li>
                        <li>
                            <a class="des">
                                <span class="icon ic_stavian" >&#xe007;</span>{{ optional(\App\Models\Datameta::getData(['field' => 'email', 'type' => 'settings']))->data_value }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="footer_item1">
                <h4>{{ __('datametas.web.footer.category') }}</h4>
                <ul class="list_txt">
                    @if(isset($options) && $options['header_menu'])
                        @foreach($options['header_menu'] as $i => $menu)
                            <li>
                                @if(!empty($menu->route_name))
                                    @if($menu->route_name != 'front.about-us')
                                        <a href="{{ route($menu->route_name) }}">
                                            {{ optional($menu->datameta('', 'name'))->data_value }}
                                        </a>
                                    @else
                                        @php($temp = $menu->posts()->where('status', \App\Models\Constant::STATUS_ACTIVE)->orderBy('sorting')->first())
                                        <a href="{{ route($menu->route_name, [
                                            'hash_key' => $temp ? optional($temp->hash_key)->code : '404-not-found',
                                            'slug' => $temp ? optional($temp->datameta(env('APP_LOCALE'), 'slug'))->data_value : '404-not-found',
                                            ]) }}">
                                            {{ optional($menu->datameta('', 'name'))->data_value }}
                                        </a>
                                    @endif
                                @else
                                    @php($post_id = optional($menu->posts()->where('status', \App\Models\Constant::STATUS_ACTIVE)->orderBy('sorting')->first())->id)
                                    <a href="{{ route('front.post.index', ['hash_key' => encrypt($post_id)]) }}">
                                        {{ optional($menu->datameta('', 'name'))->data_value }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="footer_info"><p>{{ __('datametas.web.footer.info') }}</p></div>
    </div>
</footer>
