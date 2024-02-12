@extends("admin.layout.table")

@section('detail')
    <div class="m-portlet m-portlet--full-height">

        <div class="m-portlet__body">

            @php($f = $page_setting['attr'].'-file')
            <div class="form-group m-form__group row">
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        <img class="img-thumbnail" src="{{ !empty($data->media) ? asset($data->media->web_path) : null }}"/>
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-company')
                <div class="col-xl-12 col-lg-12 col-form-label">
                    <strong>
                        {{ __('validation.attributes.' . $f) }}: {{ !empty($data->company) ? optional($data->company->datameta('', 'name'))->data_value : null }}
                    </strong>
                    <br>
                    <span>
                        {{ !empty($data->company) ? optional($data->company->datameta('', 'content'))->data_value : null }}
                    </span>
                </div>

                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.companies-working-time') }}: </strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ !empty($data->company) ? optional($data->company->datameta('', 'working-time'))->data_value : null }}
                    </span>
                </div>

                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.companies-work-location') }}: </strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        @php($work_locations = !empty($data->company) ? $data->company->work_locations : null)
                        @foreach($work_locations as $work_location)
                            {{ optional($work_location->datameta('', 'city'))->data_value }}: </strong>{{ optional($work_location->datameta('', 'address'))->data_value }}<br>
                        @endforeach
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

                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.companies-work-location') }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        @php($arr = [])
                        @php($locations = $data->locations()->get(['id']))
                        @foreach($locations as $location)
                            @php($arr[] = optional($location->datameta('', 'city'))->data_value)
                        @endforeach
                        {{ implode(', ', $arr) }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-level')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ !empty($data->job_level) ? optional($data->job_level->datameta('', 'name'))->data_value : null }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-type')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ !empty($data->job_type) ? optional($data->job_type->datameta('', 'name'))->data_value : null }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-qualification')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ optional($data->datameta('', 'qualification'))->data_value }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-experiences')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ optional($data->datameta('', 'experiences'))->data_value }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-industry')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        @php($arr = [])
                        @php($industries = $data->industries()->where('status', \App\Models\Constant::STATUS_ACTIVE)->get(['id']))
                        @foreach($industries as $industry)
                            @php($arr[] = optional($industry->datameta('', 'name'))->data_value)
                        @endforeach
                        {{ implode(', ', $arr) }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-salary')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ optional($data->datameta('', 'salary'))->data_value }}
                    </span>
                </div>

                @php($f = $page_setting['attr'].'-deadline_apply')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {{ date('d/m/Y', strtotime($data->deadline_apply)) }}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-description')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'description'))->data_value !!}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-requirement')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'requirement'))->data_value !!}
                    </span>
                </div>
            </div>

            <div class="m-separator m-separator--dashed m-separator--lg"></div>

            <div class="form-group m-form__group row">
                @php($f = $page_setting['attr'].'-benefit')
                <label class="col-xl-3 col-lg-3 col-form-label">
                    <strong>{{ __('validation.attributes.' . $f) }}:</strong>
                </label>
                <div class="col-xl-9 col-lg-9 col-form-label">
                    <span class="m-form__control-static">
                        {!! optional($data->datameta('', 'benefit'))->data_value !!}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
