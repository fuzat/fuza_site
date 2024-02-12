@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.job-types.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.job-types.update', 'id' => $id] : ['admin.job-types.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($lang) ? $lang : null), ['class' => 'form-control m-input', 'id' => !empty($lang) ? 'locale' : null]) !!}
        </div>

        @php($f = $page_setting['attr'].'-name')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'name'))->data_value : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
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
            $('#locale').change(function () {
                $.blockUI({message: ''});
                return window.location.replace(route('admin.job-types.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });
        });
    </script>
@endsection




