@extends("admin.layout.form")

@section('form_input')
    {!! Form::open(['method' => 'PUT', 'route' => ['admin.settings.update'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @foreach($data as $value)
            <div class="form-group m-form__group">
                <label>{{ __('validation.attributes.'.$page_setting['attr'].'-'.$value->setting_name) }}</label>
                @if(in_array($value->setting_name, ['logo-header', 'logo-footer']))
                    <input type="file" class="form-control m-input" name="{{ $value->setting_name }}">
                    <span class="m-form__help m--valign-top">({{ $value->setting_name == 'logo-header' ? "204*39" : "262*163" }})</span>
                    @if(!empty($value->setting_value))
                        <img src="{{ asset($value->setting_value) }}" @if($value->setting_name == 'logo-footer') style="background-color: grey;" @endif>
                    @endif
                @elseif(in_array($value->setting_name, ['seo-description', 'logo-footer-text', 'seo-title', 'email', 'address']))
                    @if($value->setting_name == 'seo-description')
                        <textarea class="form-control m-input" name="{{ $value->setting_name }}" rows="5">{{ old($value->setting_name, optional(\App\Models\Datameta::getData(['type' => 'settings', 'field' => $value->setting_name], !empty($lang) ? $lang : null))->data_value) }}</textarea>
                    @else
                        <input type="text" class="form-control m-input" name="{{ $value->setting_name }}" value="{{ old($value->setting_name, optional(\App\Models\Datameta::getData(['type' => 'settings', 'field' => $value->setting_name], !empty($lang) ? $lang : null))->data_value) }}">
                    @endif
                @elseif($value->setting_name == 'show-language')
                    {!! Form::select($value->setting_name, __('datametas.select-box.show-home'), old($value->setting_name, $value->setting_value), ['class' => 'form-control m-input']) !!}
                @else
                    <input type="text" class="form-control m-input" name="{{ $value->setting_name }}" value="{{ old($value->setting_name, $value->setting_value) }}">
                @endif
            </div>
        @endforeach

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($lang) ? $lang : null), ['class' => 'form-control m-input', 'id' => !empty($lang) ? 'locale' : null]) !!}
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
        $('#locale').on('change', function () {
            $.blockUI({message: ''});
            window.location.replace(route('admin.settings.update', {lang: $(this).val()}), true);
        });
    </script>
@endsection
