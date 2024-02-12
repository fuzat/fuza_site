@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.roles.update', 'id' => $id] : ['admin.roles.store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-name') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($page_setting['attr'].'-name', old($page_setting['attr'].'-name', !empty($id) ? $data->name : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-display_name') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($page_setting['attr'].'-display_name', old($page_setting['attr'].'-display_name', !empty($id) ? $data->display_name : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-description') }} <span class="text-danger"></span></label>
            {!! Form::text($page_setting['attr'].'-description', old($page_setting['attr'].'-description', !empty($id) ? $data->description : ''), ['class' => 'form-control m-input']) !!}
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




