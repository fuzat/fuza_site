@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    @php($prefix = \App\Models\Application::_ATTR . '-')
    <div class="banner_inside" style="background-image:url({{ asset(isset($banner) ? optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path : null) }})">
        <div class="container">
            <div class="inside_title">
                <h1>{{ mb_strtoupper($page_setting['title']) }}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('front.home') }}"><span class="ic_stavian">&#xe01a;</span></a>
                        <a href="{{ route('front.jobs.index') }}">{{ __('datametas.web.title.careers') }}</a>
                    </li>
                    <li class="active">{{ $page_setting['title'] }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="bg_grey">
        <div class="container">
            <h2 class="title_page">
                <span class="ic_stavian">&#xe014;</span>{{ __('datametas.web.join-talent-community.title') }}
                <p>{{ __('datametas.web.join-talent-community.description') }}</p>
            </h2>
            {!! Form::open(['method' => 'POST', 'route' => ['front.applicants.send-join-talent-community'], 'files' => true, 'class' => 'recruitment_form']) !!}
            <div class="form-group">
                {!! Form::label($prefix . 'name', __('datametas.web.join-talent-community.label.name')) !!}
                {!! Form::text($prefix . 'name', old($prefix . 'name', ''), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label($prefix . 'mobile', __('datametas.web.join-talent-community.label.mobile')) !!}
                {!! Form::text($prefix . 'mobile', old($prefix . 'mobile', ''), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label($prefix . 'email', __('datametas.web.join-talent-community.label.email')) !!}
                {!! Form::text($prefix . 'email', old($prefix . 'email', ''), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label($prefix . 'company', __('datametas.web.join-talent-community.label.company-name')) !!}
                {!! Form::select($prefix . 'company', $companies, old($prefix . 'company', isset($params[$prefix . 'company']) ? $params[$prefix . 'company'] : ''), ['class' => 'form-control', 'id' => 'company', 'placeholder' => __('datametas.web.join-talent-community.placeholder.choose-company')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label($prefix . 'position', __('datametas.web.join-talent-community.label.position')) !!}
                {!! Form::select($prefix . 'position', [], old($prefix . 'position', isset($params[$prefix . 'position']) ? $params[$prefix . 'position'] : ''), ['class' => 'form-control', 'id' => 'position', 'placeholder' => __('datametas.web.join-talent-community.placeholder.choose-position')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label($prefix . 'company_location', __('datametas.web.join-talent-community.label.work-place')) !!}
                {!! Form::select($prefix . 'company_location', [], old($prefix . 'company_location', ''), ['class' => 'form-control', 'id' => 'work-place', 'placeholder' => __('datametas.web.join-talent-community.placeholder.choose-work-place')]) !!}
            </div>
            <br/>
            <div class="bar_btn">
                <span id="file_name" style="display: none;"></span>
                <input type="file" name="{{ $prefix . 'cv_file' }}" id="cv_file" style="display: none;">
                <a href="javascript:void(0);" class="btn btn-default" id="btn_cv">
                    <span class="icon ic_stavian">&#xe015;</span>{{ __('datametas.web.join-talent-community.button.upload-cv') }}
                </a>
                <button class="btn btn-primary">
                    {{ __('datametas.web.join-talent-community.button.apply-now') }}<span class="icon ic_stavian">&#xe00b;</span>
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="{{ asset('js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function ajaxWorkPlace(company_id)
        {
            $.blockUI({message: ''});

            $.ajax({
                url: route('front.ajax.jobs.get-job'),
                dataType: "json",
                delay: 400,
                data: {'company_id': company_id, expired: true},
                success: function(resp) {
                    if (resp.code == 200) {
                        $('#position').html('<option value="">{{ __('custom.button.choose-position') }}</option>');
                        $.each(resp.data, function (id, name) {
                            $('#position').append($('<option>', {
                                value: id,
                                text: name,
                            }));
                        });
                    } else if (resp.code == 204) {
                        Swal.fire({
                            type: 'error',
                            title: resp.msg,
                            timer: 3000,
                        });
                    }
                },
                error: function (err) {

                }
            });

            $.ajax({
                url: '{{ route('ajax.applications.get-company-location') }}',
                method: 'GET',
                data: {'company_id': company_id},
                success: function (resp) {
                    if (resp.code == 200) {
                        $('#work-place').html('<option value="">{{ __('custom.button.choose-work-place') }}</option>');
                        $.each(resp.data, function (id, name) {
                            $('#work-place').append($('<option>', {
                                value: id,
                                text: name,
                            }));
                        });
                    } else if (resp.code == 204) {
                        Swal.fire({
                            type: 'error',
                            title: resp.msg,
                            timer: 3000,
                        });
                    }

                    $.unblockUI();
                },
                error: function (err) {
                    $.unblockUI();
                }
            });
        }

        $(function () {
            $('#btn_cv').click(function (e) {
                e.preventDefault();
                $('#cv_file').trigger('click');
            });

            $('#cv_file').change(function () {
                $('span#file_name').html('<strong>' + $(this).val().split('\\').pop() + '</strong>');
                $('span#file_name').css('display', 'block');
            });

            @if(isset($params[$prefix . 'company']) && !empty($params[$prefix . 'company']))
            ajaxWorkPlace('{{ $params[$prefix . 'company'] }}');
            @endif

            $('#company').on('change', function (e) {
                e.preventDefault();

                ajaxWorkPlace($(this).val());
            });

            $('.recruitment_form').submit(function (e) {
                e.preventDefault();

                $.blockUI({message: ''});

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        Swal.fire({
                            type: (resp.code == 200) ? 'success' : 'error',
                            title: resp.msg,
                            timer: 3000,
                        }).then(function (okay) {
                            if(okay) {
                                if (resp.code == 200)
                                    return window.location.replace(route('front.applicants.show-join-talent-community'));
                            }
                        });

                        $.unblockUI();
                    },
                    error: function (error) {
                        $.unblockUI();
                    }
                });
            });

            $('#position').select2();
        });
    </script>
    @include('front.layout.resize-banner')
@endsection
