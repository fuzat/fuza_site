@extends("admin.layout.table")

@section('detail')
    <div class="m-portlet m-portlet--full-height">

        <div class="m-portlet__body">

            @php($f = $page_setting['attr'].'-file-large')
            <div class="form-group m-form__group row">
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        <img class="img-thumbnail" src="{{ !empty($data->media_detail) ? asset($data->media_detail->web_path) : null }}"/>
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-category')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ !empty($data->category) ? optional($data->category->datameta('', 'name'))->data_value : null }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-public_date')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ !empty($data->public_date) ? \Carbon\Carbon::parse($data->public_date)->format('d/m/Y') : null }}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            @php($f = $page_setting['attr'].'-content')
            <div class="form-group m-form__group row">
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-12 col-lg-12 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'content'))->data_value !!}
                    </span>
                </div>
            </div>

        </div>
    </div>
@endsection
