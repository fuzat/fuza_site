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
                        <a href="javascript:void(0);">{{ __('datametas.web.title.careers') }}</a>
                    </li>
                    <li class="active">{{ $page_setting['title'] }}</li>
                </ol>
            </div>
        </div>
        <input type="hidden" id="mobile_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))->app_path) : null }}">
        <input type="hidden" id="web_banner" value="{{ !empty($banner) ? asset(optional($banner->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))->web_path) : null }}">
    </div>
    <div class="page_inside">
        <div class="container">
            <div class="search_bar">
                {!! Form::open(['method' => 'GET', 'route' => ['front.jobs.index'], 'class' => 'form-inline']) !!}
                <div class="form_search">
                    <div class="form-group search_field">
                        {!! Form::text('name', isset($params['name']) ? $params['name'] : null, ['class' => 'form-control', 'placeholder' => __('custom.input.search-job')]) !!}
                    </div>
                    <div class="form-group input-icon">
                        {!! Form::select('industry', $industries, isset($params['industry']) ? $params['industry'] : null, ['class' => 'form-control', 'placeholder' => __('custom.input.industry')]) !!}
                        <span class="icon ic_stavian">&#xe00a;</span>
                    </div>
                    <div class="form-group input-icon">
                        {!! Form::select('location', $locations, isset($params['location']) ? $params['location'] : null, ['class' => 'form-control', 'placeholder' => __('custom.input.location')]) !!}
                        <span class="icon ic_stavian">&#xe016;</span>
                    </div>
                    <div class="form-group input-icon">
                        {!! Form::select('company', $companies, isset($params['company']) ? $params['company'] : null, ['class' => 'form-control', 'placeholder' => __('custom.input.company')]) !!}
                        <span class="icon ic_stavian">&#xe01c;</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <span class="icon ic_stavian">&#xe004;</span>{{ __('custom.button.search') }}
                </button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="bg_grey">
            <div class="container">
                <div class="all_job">
                    <div class="job_L">
                        @if(!empty($industries))
                            <div class="block">
                                <h4 class="title_block">
                                    <a href="#menu_list" data-toggle="collapse" aria-expanded="false">
                                        {{ __('datametas.web.all-industry') }}<span class="ic_main ar_down">&#xe036;</span>
                                    </a>
                                </h4>
                                <ul class="menu_list" id="menu_list">
                                    @foreach($industries as $id => $name)
                                        <li @if(isset($params['industry']) && $params['industry'] == $id) class="active" @endif>
                                            <a href="{{ route('front.jobs.index', ['industry' => $id]) }}">
                                                {{ $name }} <span class="num">({{ \App\Models\Job::sumJob(['industry' => $id, 'expired' => date('Y-m-d')]) }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="banner_left">
                            <a href="{{ (!empty($poster) && !empty($poster->url)) ? $poster->url : 'javascript:void(0);' }}" target="_blank">
                                <img src="{{ (!empty($poster) && !empty($poster->media)) ? asset($poster->media->web_path) : null }}"/>
                            </a>
                        </div>
                    </div>
                    <div class="job_R">
                        <div class="list_jobssearch">
                            @php($prefix = \App\Models\Application::_ATTR . '-')
                            @foreach($data as $k => $item)
                                <div class="item">
                                    <div class="btn_share">
                                        <a class="share">
                                            <span class="ic_stavian">&#xe013;</span> {{ __('custom.button.share') }}
                                            <ul class="list_social_color" id="list_social_color">
                                                <li>
                                                    @php($url = "http://www.linkedin.com/shareArticle?mini=true&url=".route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value),'hash_key' => optional($item->hash_key)->code]))
                                                    <a class="icon ic_stavian linkedin" onclick="btShare('{{ $url }}', '{{ optional($item->datameta('', 'name'))->data_value }}', 500, 500)">&#xe01d;</a>
                                                </li>
                                                <li>
                                                    @php($url = "https://twitter.com/share?url=".route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value),'hash_key' => optional($item->hash_key)->code]))
                                                    <a class="icon ic_main twitter" onclick="btShare('{{ $url }}', '{{ optional($item->datameta('', 'name'))->data_value }}', 500, 500)">&#xe01e;</a>
                                                </li>
                                                <li>
                                                    @php($url = "http://www.facebook.com/sharer/sharer.php?u=".route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value),'hash_key' => optional($item->hash_key)->code]))
                                                    <a class="icon ic_main face" onclick="btShare('{{ $url }}', '{{ optional($item->datameta('', 'name'))->data_value }}', 500, 500)">&#xe01b;</a>
                                                </li>
                                            </ul>
                                        </a>
                                    </div>

                                    <a href="{{ route('front.jobs.show', [
                                    'slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value),
                                    'hash_key' => optional($item->hash_key)->code,
                                    ]) }}" class="img">
                                        <img src="{{ !empty($item->media) ? asset($item->media->web_path) : asset('images/demo/job/img1.jpg') }}"/>
                                    </a>

                                    <div class="info">
                                        <a href="{{ route('front.jobs.show', [
                                        'slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value),
                                        'hash_key' => optional($item->hash_key)->code,
                                        ]) }}" class="title">
                                            {{ optional($item->datameta('', 'name'))->data_value }}
                                        </a>

                                        <p>
                                            <span class="icon_position ic_stavian">&#xe016;</span>
                                            <span class="des">
                                                @php($arr = [])
                                                @php($company_locations = $item->locations()->get(['id']))
                                                @foreach($company_locations as $company_location)
                                                    @php($arr[] = optional($company_location->datameta('', 'city'))->data_value)
                                                @endforeach
                                                {{ implode(', ', $arr) }}
                                            </span>
                                            <span class="icon ic_main">&#xe052;</span>
                                            <span class="des">{{ __('datametas.web.salary') }}: {{ optional($item->datameta('', 'salary'))->data_value }}</span>
                                        </p>

                                        <p>
                                            <span class="des">{{ __('datametas.web.deadline-apply') }}: {{ date('d/m/Y', strtotime($item->deadline_apply)) }}</span>
                                        </p>

                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#uploadCV" id="modal-uploadCV">
                                            {{ __('custom.button.apply') }}<span class="ic_stavian icon">&#xe00b;</span>
                                        </a>

                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <input type="hidden" name="company_id" value="{{ $item->company_id }}">
                                        <input type="hidden" name="company_locations" value="{{ implode(', ', $arr) }}">
                                        <input type="hidden" name="title" value="{{ optional($item->datameta('', 'name'))->data_value }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pagination_jobs">
                            {!! $data->appends($params)->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php($prefix = \App\Models\Application::_ATTR . '-')
    <div class="modal fade" id="uploadCV" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="ic_main">&#xe04b;</span></button>
                    <div class="position_job_grey">
                        <p>{{ __('datametas.web.applying-position') }}</p>
                        <h4 id="job-name"></h4>
                        <p>
                            {{ __('validation.attributes.companies-work-location') }}:
                            <span id="companies-work-location"></span>
                        </p>
                    </div>
                </div>
                {!! Form::open(['method' => 'POST', 'route' => ['front.applicants.send-join-talent-community'], 'files' => true, 'class' => 'popup_form']) !!}
                <div class="modal-body pop_info">
                    @php($f = $prefix . 'name')
                    <div class="form-group">
                        {!! Form::label($f, __('validation.attributes.' . $f)) !!}
                        {!! Form::text($f, old($f, ''), ['class' => 'form-control']) !!}
                    </div>

                    @php($f = $prefix . 'mobile')
                    <div class="form-group">
                        {!! Form::label($f, __('validation.attributes.' . $f)) !!}
                        {!! Form::text($f, old($f, ''), ['class' => 'form-control']) !!}
                    </div>

                    @php($f = $prefix . 'email')
                    <div class="form-group">
                        {!! Form::label($f, __('validation.attributes.' . $f)) !!}
                        {!! Form::text($f, old($f, ''), ['class' => 'form-control']) !!}
                    </div>

                    @php($f = $prefix . 'company_location')
                    <div class="form-group">
                        {!! Form::label($f, __('validation.attributes.' . $f)) !!}
                        {!! Form::select($f, [], old($f, ''), ['class' => 'form-control', 'id' => 'work-place', 'placeholder' => __('custom.button.choose-work-place')]) !!}
                    </div>

                    @php($f = $prefix . 'cv_file')
                    <p class="pop_title"><strong><span id="file_name" style="display: none;"></span></strong></p>
                    <input type="file" name="{{ $f }}" id="cv_file" style="display: none;">

                    <p>{{ __('datametas.web.upload-from-computer') }}</p>

                    <a href="javascript:void(0);" class="btn btn-grey" id="btn_cv">
                        <span class="ic_stavian">&#xe015;</span>{{ __('custom.button.upload-cv') }}
                    </a>

                    <p style="margin-top: 5px;">{{ __('datametas.web.support-format-file') }}</p>

                    {!! Form::hidden($prefix . 'position', old($prefix . 'position', ''), ['class' => 'form-control', 'id' => 'position']) !!}
                    {!! Form::hidden($prefix . 'company', old($prefix . 'company', ''), ['class' => 'form-control', 'id' => 'company']) !!}
                </div>
                <div class="modal-footer">
                    <div class="pop_btn" role="group" aria-label="group button">
                        <button type="button" class="btn btn-default" data-dismiss="modal" role="button">
                            {{ __('custom.button.cancel') }}
                        </button>
                        <button class="btn btn-primary" role="button">
                            {{ __('custom.button.apply-now') }}
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('script')
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#btn_cv').click(function (e) {
                e.preventDefault();
                $('#cv_file').trigger('click');
            });

            $('#cv_file').change(function () {
                $('span#file_name').html('<strong>' + $(this).val().split('\\').pop() + '</strong>');
                $('span#file_name').css('display', 'block');
            });

            $('.list_jobssearch').on('click', '#modal-uploadCV', function () {
                var id = $(this).closest('.info').find('input[name=id]').val();
                var title = $(this).closest('.info').find('input[name=title]').val();
                var company_id = $(this).closest('.info').find('input[name=company_id]').val();
                var company_locations = $(this).closest('.info').find('input[name=company_locations]').val();

                $('#position').val(id);
                $('#company').val(company_id);

                $('#job-name').html(title);
                $('#companies-work-location').html(company_locations);

                $.blockUI({message: ''});

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
            });

            $('form.popup_form').submit(function (e) {
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
                                    return window.location.reload(true);
                            }
                        });

                        $.unblockUI();
                    },
                    error: function (error) {
                        $.unblockUI();
                    }
                });
            });
        });

        function btShare(url, title, winWidth, winHeight) {
            var winTop = (screen.height / 2) - (winHeight / 2);
            var winLeft = (screen.width / 2) - (winWidth / 2);
            window.open(url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width='+winWidth+',height='+winHeight);
        }
    </script>
    @include('front.layout.resize-banner')
@endsection
