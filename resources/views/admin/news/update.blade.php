@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.news.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.news.update', 'id' => $id] : ['admin.news.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($id) ? $lang : env('APP_LOCALE')), ['class' => 'form-control m-input', 'id' => !empty($id) ? 'locale' : null]) !!}
        </div>

        @php($f = $page_setting['attr'].'-name')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'name'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-category')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $categories, old($f, !empty($id) ? $data->category_id : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-public_date')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            <div class="input-group date">
                {!! Form::text($f, old($f, !empty($id) ? (!empty($data->public_date) ? \Carbon\Carbon::parse($data->public_date)->format('d/m/Y') : null) : null), ['class' => 'form-control m-datepicker', 'readonly']) !!}
                <div class="input-group-append">
                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                </div>
            </div>
        </div>

        {{--@php($f = $page_setting['attr'].'-file')--}}
        {{--<div class="form-group m-form__group">--}}
            {{--<label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>--}}
            {{--{!! Form::file($f, ['class' => 'form-control m-input']) !!}--}}
            {{--<span class="m-form__help m--valign-top">(380*220)</span>--}}
            {{--@if(!empty($id) && $data->media)--}}
                {{--<img src="{{ asset($data->media->thumbnail_path) }}">--}}
            {{--@endif--}}
        {{--</div>--}}

        @php($f = $page_setting['attr'].'-file-large')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(718*363)</span>
            @if(!empty($id) && $data->media_detail)
                <img src="{{ asset($data->media_detail->thumbnail_path) }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-video')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            @if(!empty($id) && $data->video)
                <video width="380" height="220" controls>
                    <source src="{{ asset($data->video->full_path) }}" type="video/mp4">
                </video>
            @endif
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.hot_news') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('hot_news', __('datametas.select-box.hot_news'), old('hot_news', !empty($id) ? $data->hot_news : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input', 'id' => 'hot_news']) !!}
        </div>

        @php($f = $page_setting['attr'].'-file-big')
        <div class="form-group m-form__group" style="display: none;" id="media_big">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(690*480)</span>
            @if(!empty($id) && $data->media_big)
                <img src="{{ asset($data->media_big->thumbnail_path) }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-carousel')
        <div class="form-group m-form__group" style="display: none;" id="carousel">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(480*225)</span>
            @if(!empty($id) && $data->carousel)
                <img src="{{ asset($data->carousel->thumbnail_path) }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-content')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'content'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'content']) !!}
        </div>

        @php($f = $page_setting['attr'].'-seo_title')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'seo_title'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-seo_description')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'seo_description'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            {!! Form::submit(__('custom.button.save'), ['class' => 'btn btn-primary', 'onclick' => "$.blockUI({message: ''});",]) !!}
            {!! Form::reset(__('custom.button.reset'), ['class' => 'btn btn-secondary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section("script")
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        function showImageHotNews(hot_news) {
            if (hot_news == '{{ \App\Models\Constant::STATUS_ACTIVE }}') {
                $('#media_big').css('display', 'block');
                $('#carousel').css('display', 'block');
            } else {
                $('#media_big').css('display', 'none');
                $('#carousel').css('display', 'none');
            }
        }

        $(function () {
            $('input.m-datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: "linked",
                clearBtn: !0,
                todayHighlight: !0,
            });

            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.news.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            CKEDITOR.replace('content', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });

            if (typeof CKEDITOR != 'undefined') {
                $('form').on('reset', function(e) {
                    if ($(CKEDITOR.instances).length) {
                        for (var key in CKEDITOR.instances) {
                            var instance = CKEDITOR.instances[key];
                            if ($(instance.element.$).closest('form').attr('name') == $(e.target).attr('name')) {
                                instance.setData(instance.element.$.defaultValue);
                            }
                        }
                    }
                });
            }

            @if(!empty($id) && $data->hot_news == \App\Models\Constant::STATUS_ACTIVE)
            $('#media_big').css('display', 'block');
            @endif

            @if(!empty($id) && $data->hot_news == \App\Models\Constant::STATUS_ACTIVE)
            $('#carousel').css('display', 'block');
            @endif

            $('#hot_news').trigger('change');

            $('#hot_news').change(function (e) {
                e.preventDefault();
                showImageHotNews($(this).val());
            });

            if ($('#hot_news').val() == '{{ \App\Models\Constant::STATUS_ACTIVE }}')
                showImageHotNews($('#hot_news').val());
        });
    </script>
@endsection
