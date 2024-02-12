@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.companies.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.companies.update', 'id' => $id] : ['admin.companies.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
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

        @php($f = $page_setting['attr'].'-email')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? $data->email : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-logo')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(380*200)</span>
            @if(!empty($id) && $data->media)
                <img src="{{ $data->media->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-content')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'content'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-working-time')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'working-time'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_ACTIVE), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-work-location')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::button(__('custom.button.add'), ['class' => 'btn btn-sm btn-info', 'id' => 'add_choice_btn_id']) !!}
        </div>

        <div id="choice_form_id">
            @if (empty($id))
                <div class="form-group m-form__group row">
                    @php($f = $page_setting['attr'].'-city')
                    <div class="col-md-2">
                        {!! Form::select($f.'[]', $locations, null, ['class' => 'form-control m-input', 'placeholder' => __('validation.attributes.'.$f)]) !!}
                    </div>

                    @php($f = $page_setting['attr'].'-address')
                    <div class="col-md-8">
                        {!! Form::text($f.'[]', null, ['class' => 'form-control m-input', 'placeholder' => __('validation.attributes.'.$f)]) !!}
                    </div>

                    <div class="col-md-2">
                        {!! Form::button(__('custom.button.delete'), ['class' => 'btn btn-sm btn-danger pull-right del_form']) !!}
                    </div>
                </div>
            @else
                @foreach($data->work_locations as $j => $item)
                    <div class="form-group m-form__group row">
                        @php($f = $page_setting['attr'].'-city')
                        <div class="col-md-2">
                            {!! Form::select($f.'['.$j.']', $locations, $item->location_id, ['class' => 'form-control m-input', 'placeholder' => __('validation.attributes.'.$f)]) !!}
                        </div>

                        @php($f = $page_setting['attr'].'-address')
                        <div class="col-md-8">
                            {!! Form::text($f.'['.$j.']', optional($item->datameta($lang, 'address'))->data_value, ['class' => 'form-control m-input', 'placeholder' => __('validation.attributes.'.$f)]) !!}
                        </div>

                        <div class="col-md-2">
                            {!! Form::button(__('custom.button.delete'), ['class' => 'btn btn-sm btn-danger pull-right del_form']) !!}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            {!! Form::submit(__('custom.button.save'), ['class' => 'btn btn-primary', 'onclick' => "$.blockUI({message: ''});",]) !!}
            {!! Form::reset(__('custom.button.reset'), ['class' => 'btn btn-secondary']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <div style="display: none;">
        <div id="add_choice_form_id">
            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-city')
                <div class="col-md-2">
                    {!! Form::select($f.'[]', $locations, null, ['class' => 'form-control m-input', 'placeholder' => __('validation.attributes.'.$f)]) !!}
                </div>

                @php($f = $page_setting['attr'].'-address')
                <div class="col-md-8">
                    {!! Form::text($f.'[]', null, ['class' => 'form-control m-input', 'placeholder' => __('validation.attributes.'.$f)]) !!}
                </div>

                <div class="col-md-2">
                    {!! Form::button(__('custom.button.delete'), ['class' => 'btn btn-sm btn-danger pull-right del_form']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script type="text/javascript">
        $(function () {
            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.companies.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            $('#add_choice_btn_id').on('click', function () {
                $('#choice_form_id').append($('#add_choice_form_id').html());
            });

            $('body').on('click','.del_form', function () {
                if (confirm('{{ __('custom.confirm.delete') }}'))
                    $(this).closest(".row").remove();
            });
        });
    </script>
@endsection
