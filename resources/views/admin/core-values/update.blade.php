@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.core-values.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.core-values.update', 'id' => $id] : ['admin.core-values.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
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

        @php($f = $page_setting['attr'].'-avatar')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(1203*400)</span>
            @if(!empty($id))
                @php($media = \App\Models\Media::getOneMedia(['locale' => $lang, 'obj_id' => $id, 'obj_type' => \App\Models\Media::OBJ_TYPE_CORE_VALUE_AVATAR]))
                @if(!empty($media))
                    <img src="{{ $media->thumbnail_path }}">
                @endif
            @endif
        </div>

        @php($f = $page_setting['attr'].'-file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(770*770)</span>
            @if(!empty($id))
                @php($media = \App\Models\Media::getOneMedia(['locale' => $lang, 'obj_id' => $id, 'obj_type' => \App\Models\Media::OBJ_TYPE_CORE_VALUE_FILE]))
                @if(!empty($media))
                    <img src="{{ $media->thumbnail_path }}">
                @endif
            @endif
        </div>

        @php($f = $page_setting['attr'].'-file-how')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(406*406)</span>
            @if(!empty($id) && $data->file_how)
                @php($media = \App\Models\Media::getOneMedia(['locale' => $lang, 'obj_id' => $id, 'obj_type' => \App\Models\Media::OBJ_TYPE_CORE_VALUE_FILE_HOW]))
                @if(!empty($media))
                    <img src="{{ $media->thumbnail_path }}">
                @endif
            @endif
        </div>

        @php($f = $page_setting['attr'].'-how')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'how'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-who')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'who'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-what')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'what'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-where')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'where'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-when')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'when'))->data_value : null), ['class' => 'form-control m-input']) !!}
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
    <script type="text/javascript">
        $(function () {
            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.core-values.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });
        });
    </script>
@endsection
