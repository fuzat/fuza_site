@extends("admin.layout.table")

@section('detail')
    <div class="m-portlet m-portlet--full-height">

        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-avatar')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        <img class="img-thumbnail" src="{{ !empty($data->avatar) ? asset($data->avatar->web_path) : null }}"/>
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-name')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ optional($data->datameta('', 'name'))->data_value }}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-short-desc')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'short-desc'))->data_value !!}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-content')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'content'))->data_value !!}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-scale-operation')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'scale-operation'))->data_value !!}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-development-strategy')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'development-strategy'))->data_value !!}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-our-products')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'our-products'))->data_value !!}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
