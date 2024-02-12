@extends("admin.layout.app")

@section('title', $page_setting['title'])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Section-->
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet " id="m_portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon"><i class="flaticon-map"></i></span>
                                    <h3 class="m-portlet__head-text">
                                        Dashboard
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="text-center">
                                <img src="{{ asset('images/Sitemap_Stavian.png') }}">
                            </div>
                        </div>
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
            <!--End::Section-->
        </div>
    </div>
@endsection

@section("script")

@endsection
