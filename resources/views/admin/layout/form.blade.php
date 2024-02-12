@extends("admin.layout.app")

@section('title', $page_setting['title'])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            @include('admin.layout.redirect_msg')
            <div class="row">
                <div class="{{ isset($page_setting['custom_page_class']) ? $page_setting['custom_page_class'] : 'col-md-6 offset-md-3' }}">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title w-100">
                                    <h3 class="m-portlet__head-text">
                                        {{ $page_setting['title'] }}
                                    </h3>
                                    @yield('link_url')
                                </div>
                            </div>
                        </div>
                        @yield('form_input')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
