@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.jobs.update', 'id' => $id] : ['admin.jobs.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($lang) ? $lang : null), ['class' => 'form-control m-input singleselect_custom', 'id' => !empty($lang) ? 'locale' : null]) !!}
        </div>

        @php($f = $page_setting['attr'].'-name')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'name'))->data_value : ''), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-type')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $job_types, old($f, !empty($id) ? $data->type_id : ''), ['class' => 'form-control m-select2', 'placeholder' => __('datametas.placeholder.choose.job-type')]) !!}
        </div>

        @php($f = $page_setting['attr'].'-level')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $job_levels, old($f, !empty($id) ? $data->level_id : ''), ['class' => 'form-control m-select2', 'placeholder' => __('datametas.placeholder.choose.job-level')]) !!}
        </div>

        @php($f = $page_setting['attr'].'-salary')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'salary'))->data_value : ''), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {{ Form::file($f, ['class' => 'form-control m-input']) }}
            <span class="m-form__help m--valign-top">(130*130)</span>
            @if(!empty($id) && $data->media)
                <img src="{{ $data->media->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-company')
        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $companies, old($f, !empty($id) ? $data->company_id : ''), ['class' => 'form-control m-input m-select2', 'id' => 'company']) !!}
        </div>

        @php($f = $page_setting['attr'].'-location')
        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f.'[]', $locations, old($f.'[]', !empty($id) ? $data->locations()->get(['id'])->pluck('id')->toArray() : null), ['class' => 'form-control m-input m-select2', 'multiple' => 'multiple', 'id' => 'location']) !!}
        </div>

        @php($f = $page_setting['attr'].'-industry')
        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f.'[]', $industries, old($f.'[]', !empty($id) ? $data->industries()->get(['id'])->pluck('id') : null), ['class' => 'form-control m-input m-select2', 'multiple' => 'multiple']) !!}
        </div>

        @php($f = $page_setting['attr'].'-deadline_apply')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? date('d/m/Y', strtotime($data->deadline_apply)) : ''), ['readonly' => 'true', 'class' => 'form-control m-input m-datepicker']) !!}
        </div>

        @php($f = $page_setting['attr'].'-experiences')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'experiences'))->data_value : ''), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-qualification')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'qualification'))->data_value : ''), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-description')
        <div class="form-group m-form__group" id="div_description_id">
            <label for="">{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'description'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'description']) !!}
        </div>

        @php($f = $page_setting['attr'].'-requirement')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'requirement'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'requirement']) !!}
        </div>

        @php($f = $page_setting['attr'].'-benefit')
        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'benefit'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'benefit']) !!}
        </div>

        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
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
        $(function () {
            CKEDITOR.replace('benefit', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('description', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('requirement', {
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

            $('.m-select2').select2({});

            $( ".m-datepicker" ).datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                clearBtn: true,
                todayBtn: "linked",
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });

            $('#locale').change(function () {
                $.blockUI({message: ''});
                return window.location.replace(route('admin.jobs.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            $('#company').change(function () {
                $.blockUI({message: ''});

                $.ajax({
                    url: '{{ route('ajax.applications.get-company-location') }}',
                    method: 'GET',
                    data: {'company_id': $(this).val()},
                    success: function (response) {
                        if (response.code == 204) {
                            swal("", response.msg, "error");
                        } else if (response.code == 200) {
                            $('#location').html('<option value=""></option>');
                            $.each(response.data, function (id, name) {
                                $('#location').append($('<option>', {
                                    value: id,
                                    text: name,
                                }));
                            });
                        }

                        $.unblockUI();
                    },
                    error: function (err) {
                        $.unblockUI();
                    }
                });
            });

            @if(empty($id))
            $('#company').trigger('change');
            @endif
        });
    </script>
@endsection




