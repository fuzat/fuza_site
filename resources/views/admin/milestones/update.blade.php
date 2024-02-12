@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.milestones.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.milestones.update', 'id' => $id] : ['admin.milestones.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
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

        @php($f = $page_setting['attr'].'-year')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? $data->year : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(278*210)</span>
            @if(!empty($id) && $data->media)
                <img src="{{ $data->media->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-description')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'description'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'description']) !!}
        </div>

        @php($f = $page_setting['attr'].'-hover')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'hover'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'hover']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_ACTIVE), ['class' => 'form-control m-input']) !!}
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
            CKEDITOR.replace('description', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('hover', {
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

            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.milestones.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });
        });
    </script>
@endsection