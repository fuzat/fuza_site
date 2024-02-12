@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.groups.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    @php($prefix = $page_setting['attr'] . '-')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.groups.update', 'id' => $id] : ['admin.groups.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.' . $prefix . 'name') }}</label>
            {!! Form::text($prefix . 'name', old($prefix . 'name', !empty($id) ? $data->name : ''), ['class' => 'form-control m-input']) !!}
        </div>
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.' . $prefix . 'file') }} <span class="text-danger">(*)</span></label>
            {!! Form::file($prefix . 'file', ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(190*190)</span>
            @if(!empty($id) && $data->media)
                <img src="{{ $data->media->thumbnail_path }}">
            @endif
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
@endsection
