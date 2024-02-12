@extends('front.layout.app')

@section('title', isset($page_setting['title']) ? $page_setting['title'] : null)

@section('content')
    @php($job_name = optional($data->datameta('', 'name'))->data_value)
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
    <div class="page_inside">
        <div class="row">
            <div class="container">
                <div class="all_job">
                    <div class="job_R">
                        <div class="job_detail">
                            <h2>{{ $job_name }}</h2>
                            <ul class="job_info">
                                <li>
                                    <span class="text">{{ __('validation.attributes.companies-work-location') }}: </span>
                                    @php($arr = [])
                                    @php($locations = $data->locations()->get(['id']))
                                    @foreach($locations as $location)
                                        @php($arr[] = optional($location->datameta('', 'city'))->data_value)
                                    @endforeach
                                    {{ implode(', ', $arr) }}
                                </li>
                                <li>
                                    <span class="text">{{ __('validation.attributes.jobs-level') }}: </span>
                                    {{ !empty($data->job_level) ? optional($data->job_level->datameta('', 'name'))->data_value : null }}
                                </li>
                                <li>
                                    <span class="text">{{ __('validation.attributes.jobs-type') }}: </span>
                                    {{ !empty($data->job_type) ? optional($data->job_type->datameta('', 'name'))->data_value : null }}
                                </li>
                                <li>
                                    <span class="text">{{ __('validation.attributes.jobs-qualification') }}: </span>
                                    {{ optional($data->datameta('', 'qualification'))->data_value }}
                                </li>
                                <li>
                                    <span class="text">{{ __('validation.attributes.jobs-experiences') }}: </span>
                                    {{ optional($data->datameta('', 'experiences'))->data_value }}
                                </li>
                                <li>
                                    <span class="text">{{ __('validation.attributes.jobs-industry') }}: </span>
                                    @php($arr = [])
                                    @php($industries = $data->industries()->where('status', \App\Models\Constant::STATUS_ACTIVE)->get(['id']))
                                    @foreach($industries as $industry)
                                        @php($arr[] = optional($industry->datameta('', 'name'))->data_value)
                                    @endforeach
                                    {{ implode(', ', $arr) }}
                                </li>
                                <li class="salary">
                                    <span class="text">{{ __('validation.attributes.jobs-salary') }}: </span>
                                    {{ optional($data->datameta('', 'salary'))->data_value }}
                                </li>
                                <li>
                                    <span class="text">{{ __('validation.attributes.jobs-deadline_apply') }}: </span>
                                    {{ date('d/m/Y', strtotime($data->deadline_apply)) }}
                                </li>
                            </ul>
                            <div class="bar_btn">
                                <a class="btn btn-primary" href="" data-toggle="modal" data-target="#uploadCV">
                                    {{ __('custom.button.apply') }}<span class="ic_stavian icon">&#xe00b;</span>
                                </a>
                                <div class="btn_share">
                                    <a class="share">
                                        <span class="ic_stavian">&#xe013;</span> {{ __('custom.button.share') }}
                                        <ul class="list_social_color" id="list_social_color">
                                            <li>
                                                @php($url = "http://www.linkedin.com/shareArticle?mini=true&url=".route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($data->datameta('', 'name'))->data_value),'hash_key' => optional($data->hash_key)->code]))
                                                <a class="icon ic_stavian linkedin" onclick="btShare('{{ $url }}', '{{ optional($data->datameta('', 'name'))->data_value }}', 500, 500)">&#xe01d;</a>
                                            </li>
                                            <li>
                                                @php($url = "https://twitter.com/share?url=".route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($data->datameta('', 'name'))->data_value),'hash_key' => optional($data->hash_key)->code]))
                                                <a class="icon ic_main twitter" onclick="btShare('{{ $url }}', '{{ optional($data->datameta('', 'name'))->data_value }}', 500, 500)">&#xe01e;</a>
                                            </li>
                                            <li>
                                                @php($url = "http://www.facebook.com/sharer/sharer.php?u=".route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($data->datameta('', 'name'))->data_value),'hash_key' => optional($data->hash_key)->code]))
                                                <a class="icon ic_main face" onclick="btShare('{{ $url }}', '{{ optional($data->datameta('', 'name'))->data_value }}', 500, 500)">&#xe01b;</a>
                                            </li>
                                        </ul>
                                    </a>
                                </div>
                            </div>
                            <h4>{{ __('validation.attributes.jobs-description') }}</h4>
                            <div class="jobs_des">
                                {!! optional($data->datameta('', 'description'))->data_value !!}
                            </div>
                            <h4>{{ __('validation.attributes.jobs-requirement') }}</h4>
                            <div class="jobs_des">
                                {!! optional($data->datameta('', 'requirement'))->data_value !!}
                            </div>
                            <h4>{{ __('validation.attributes.jobs-benefit') }}</h4>
                            <div class="jobs_des">
                                {!! optional($data->datameta('', 'benefit'))->data_value !!}
                            </div>
                        </div>
                    </div>
                    <div class="job_L">
                        @if(!empty($data->company))
                            <div class="company_block">
                                <img src="{{ !empty($data->company->media) ? asset($data->company->media->web_path) : null }}"/>
                                <h4>{{ optional($data->company->datameta('', 'name'))->data_value }}</h4>
                                <div class="des">
                                    <p>
                                        {{ optional($data->company->datameta('', 'content'))->data_value }}
                                    </p>
                                    <p>
                                        <strong>{{ __('validation.attributes.companies-working-time') }}: </strong>
                                    </p>
                                    <p>
                                        {{ optional($data->company->datameta('', 'working-time'))->data_value }}
                                    </p>
                                    <p>
                                        <strong>{{ __('validation.attributes.companies-work-location') }}:</strong>
                                    </p>
                                    @php($work_locations = $data->company->work_locations)
                                    @foreach($work_locations as $work_location)
                                        <p>
                                            <strong>{{ optional($work_location->datameta('', 'city'))->data_value }}: </strong>{{ optional($work_location->datameta('', 'address'))->data_value }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="block_grey">
                            <h4>{{ __('datametas.web.similar-job') }}</h4>
                            <div class="list_jobs list_jobsR">
                                @foreach($similar_jobs as $similar_job)
                                    <div class="item">
                                        <a href="{{ route('front.jobs.show', [
                                        'slug' => Illuminate\Support\Str::slug(optional($similar_job->datameta('', 'name'))->data_value),
                                        'hash_key' => optional($similar_job->hash_key)->code,
                                        ]) }}" class="img">
                                            <img src="{{ !empty($similar_job->media) ? asset($similar_job->media->web_path) : asset('images/demo/job/img1.jpg') }}"/>
                                        </a>
                                        <div class="info">
                                            <a href="{{ route('front.jobs.show', [
                                            'slug' => Illuminate\Support\Str::slug(optional($similar_job->datameta('', 'name'))->data_value),
                                            'hash_key' => optional($similar_job->hash_key)->code,
                                            ]) }}" class="title">
                                                {{ optional($similar_job->datameta('', 'name'))->data_value }}
                                            </a>
                                            <p>
                                                <span class="icon_position ic_stavian">&#xe016;</span>
                                                <span class="des">
                                                    @php($arr = [])
                                                    @php($locations = $similar_job->locations()->get(['id']))
                                                    @foreach($locations as $location)
                                                        @php($arr[] = optional($location->datameta('', 'city'))->data_value)
                                                    @endforeach
                                                    {{ implode(', ', $arr) }}
                                                </span>
                                            </p>
                                            <p>
                                                <span class="des"><span class="icon ic_main">&#xe07e;</span>{{ __('datametas.web.deadline-apply') }}: {{ date('d/m/Y', strtotime($similar_job->deadline_apply)) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
                        <h4>{{ $job_name }}</h4>
                        <p>
                            {{ __('validation.attributes.companies-work-location') }}:
                            @php($arr = [])
                            @php($locations = $data->locations()->get(['id']))
                            @foreach($locations as $location)
                                @php($arr[] = optional($location->datameta('', 'city'))->data_value)
                            @endforeach
                            {{ implode(', ', $arr) }}
                        </p>
                    </div>
                </div>
                {!! Form::open(['method' => 'POST', 'route' => ['front.applicants.send-join-talent-community'], 'files' => true, 'class' => 'popup_form']) !!}
                <div class="modal-body pop_info">
                    <div class="form-group">
                        {!! Form::label($prefix . 'name', __('validation.attributes.' . $prefix . 'name')) !!}
                        {!! Form::text($prefix . 'name', old($prefix . 'name', ''), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($prefix . 'mobile', __('validation.attributes.' . $prefix . 'mobile')) !!}
                        {!! Form::text($prefix . 'mobile', old($prefix . 'mobile', ''), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($prefix . 'email', __('validation.attributes.' . $prefix . 'email')) !!}
                        {!! Form::text($prefix . 'email', old($prefix . 'email', ''), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($prefix . 'company_location', __('validation.attributes.' . $prefix . 'company_location')) !!}
                        {!! Form::select($prefix . 'company_location', \App\Models\CompanyLocation::getList(['company' => $data->company_id]), old($prefix . 'company_location', ''), ['class' => 'form-control', 'id' => 'work-place', 'placeholder' => __('custom.button.choose-work-place')]) !!}
                    </div>
                    <p class="pop_title"><strong><span id="file_name" style="display: none;"></span></strong></p>
                    <input type="file" name="{{ $prefix . 'cv_file' }}" id="cv_file" style="display: none;">

                    <p>{{ __('datametas.web.upload-from-computer') }}</p>

                    <a href="javascript:void(0);" class="btn btn-grey" id="btn_cv">
                        <span class="ic_stavian">&#xe015;</span>{{ __('custom.button.upload-cv') }}
                    </a>

                    <p style="margin-top: 5px;">{{ __('datametas.web.support-format-file') }}</p>

                    {!! Form::hidden($prefix . 'position', old($prefix . 'position', $data->id), ['class' => 'form-control']) !!}
                    {!! Form::hidden($prefix . 'company', old($prefix . 'company', $data->company_id), ['class' => 'form-control']) !!}
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
