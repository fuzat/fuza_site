@extends("admin.layout.app")

@section('title', $page_setting['title'])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title w-100">
                                    <h3 class="m-portlet__head-text">
                                        {{
                                        (!isset($page_setting['detail']) || (isset($page_setting['detail']) && $page_setting['detail'] == false)) ?
                                        $page_setting['title'] : optional($data->datameta('', 'name'))->data_value
                                        }}
                                    </h3>
                                    @yield('link_url')
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            @if(!isset($page_setting['detail']) || (isset($page_setting['detail']) && $page_setting['detail'] == false))
                                <div class="row">
                                    <div class="col-xl-12">
                                        @include('admin.layout.redirect_msg')
                                        <div class="m-section">
                                            @yield('search')
                                        </div>
                                    </div>
                                </div>
                                <div class="m-section">
                                    <div class="table-responsive">
                                        @yield('list')
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="m-section">
                                            @yield('detail')
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
