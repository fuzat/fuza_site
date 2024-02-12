@extends("admin.layout.form")

@section('link_url')

@endsection

@section('form_input')
    {!! Form::open(['method' => 'POST', 'route' => ['admin.users.profile'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-name') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($page_setting['attr'].'-name', old($page_setting['attr'].'-name', $auth->name), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-email') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($page_setting['attr'].'-email', $auth->email, ['class' => 'form-control m-input', 'disabled']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-phone_number') }} <span class="text-danger"></span></label>
            {!! Form::text($page_setting['attr'].'-phone_number', old($page_setting['attr'].'-phone_number', $auth->phone_number), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-current_password') }} <span class="text-danger"></span></label>
            {!! Form::password($page_setting['attr'].'-current_password', ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-new_password') }} <span class="text-danger"></span></label>
            {!! Form::password($page_setting['attr'].'-new_password', ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-new_password_confirmation') }} <span class="text-danger"></span></label>
            {!! Form::password($page_setting['attr'].'-new_password_confirmation', ['class' => 'form-control m-input']) !!}
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
    <script>
        $(function () {

        });
    </script>
@endsection




