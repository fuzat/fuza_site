@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => 'admin.jobs.index', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'filtering_main_form_id']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name',  __('validation.attributes.'.$page_setting['attr'].'-name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', isset($search['name']) ? $search['name'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('type', __('validation.attributes.'.$page_setting['attr'].'-type')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('type', $job_types, isset($search['type']) ? $search['type'] : null, ['class' => 'form-control m-input', 'placeholder' => __('datametas.select-box.all')]) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('level', __('validation.attributes.'.$page_setting['attr'].'-level')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('level', $job_levels, isset($search['level']) ? $search['level'] : null, ['class' => 'form-control m-input', 'placeholder' => __('datametas.select-box.all')]) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('deadline_apply', __('validation.attributes.'.$page_setting['attr'].'-deadline_apply')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('deadline_apply', isset($search['deadline_apply']) ? $search['deadline_apply'] : null, ['readonly' => 'true', 'class' => 'form-control m-input m-datepicker']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('experiences', __('validation.attributes.'.$page_setting['attr'].'-experiences')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('experiences', isset($search['experiences']) ? $search['experiences'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('qualification', __('validation.attributes.'.$page_setting['attr'].'-qualification')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('qualification', isset($search['qualification']) ? $search['qualification'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('company', __('validation.attributes.'.$page_setting['attr'].'-company')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('company', $companies, isset($search['company']) ? $search['company'] : null, ['placeholder' =>  __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('location', __('validation.attributes.'.$page_setting['attr'].'-location')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('location', $locations, isset($search['location']) ? $search['location'] : null, ['placeholder' =>  __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('industry', __('validation.attributes.'.$page_setting['attr'].'-industry')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('industry', $industries, isset($search['industry']) ? $search['industry'] : null, ['placeholder' =>  __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status',  __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.status'), \Input::get('status'), ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-job">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-file') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-company') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-name') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-type') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-level') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-location') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-industry') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-experiences') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-qualification') }}</th>
            <th>{{ __('validation.attributes.'.$page_setting['attr'].'-deadline_apply') }}</th>
            <th>{{ __('validation.attributes.locale') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ ($i + 1) }}</td>
                <td>
                    @if($item->media)
                        <img src="{{ !empty($item->media) ? asset($item->media->thumbnail_path) : null }}">
                    @endif
                </td>
                <td>{{ !empty($item->company) ? strip_tags(optional($item->company->datameta('', 'name'))->data_value) : null }}</td>
                <td>{{ strip_tags(optional($item->datameta('', 'name'))->data_value) }}</td>
                <td>{{ !empty($item->job_type) ? strip_tags(optional($item->job_type->datameta('', 'name'))->data_value) : null }}</td>
                <td>{{ !empty($item->job_level) ? strip_tags(optional($item->job_level->datameta('', 'name'))->data_value) : null }}</td>
                <td>
                    @php($arr_location = [])
                    @foreach($item->locations()->get(['id']) as $location)
                        @php($arr_location[] = strip_tags(optional($location->datameta('', 'city'))->data_value))
                    @endforeach
                    {{ implode(', ', $arr_location) }}
                </td>
                <td>
                    @php($arr_industry = [])
                    @foreach($item->industries()->get(['id']) as $industry)
                        @php($arr_industry[] = strip_tags(optional($industry->datameta('', 'name'))->data_value))
                    @endforeach
                    {{ implode(', ', $arr_industry) }}
                </td>
                <td>{{ strip_tags(optional($item->datameta('', 'experiences'))->data_value) }}</td>
                <td>{{ strip_tags(optional($item->datameta('', 'qualification'))->data_value) }}</td>
                <td>{{ !empty($item->deadline_apply) ? \Carbon\Carbon::parse($item->deadline_apply)->format('d/m/Y') : null }}</td>
                <td>
                    @foreach(\App\Models\Datameta::getExistLanguages(['type' => \App\Models\Datameta::TYPE_JOB, 'id' => $item->id, 'field' => 'name']) as $k => $language)
                        @php($lang = str_replace('name_', '', $language->data_field))
                        <a href="{{ route('admin.jobs.edit', ['id' => $item->id, 'lang' => $lang]) }}">
                            <span class="flag-icon flag-icon-{{ config('laravellocalization.cssFlags')[$lang] }}"></span>
                        </a>
                    @endforeach
                </td>
                <td>
                    <div class="m-form__group form-group row">
                        <div class="m-switch m-switch--outline m-switch--icon m-switch--primary">
                            <label>
                                <input type="checkbox" {{ ($item->status == \App\Models\Constant::STATUS_ACTIVE) ? 'checked' : null }} onchange="changeStatus({{ $item->id }});">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="{{ route('admin.jobs.edit', ['id' => $item->id]) }}" class="text-warning" title="{{ __('custom.button.update') }}">
                        <i class="la la-pencil"></i>
                    </a>
                    <a href="{{ route('admin.jobs.show', ['id' => $item->id]) }}" class="text-info" title="{{ __('custom.button.show') }}">
                        <i class="la la-eye"></i>
                    </a>

                    @if($item->status == \App\Models\Constant::STATUS_ACTIVE)
                        @php($route = route('front.jobs.show', ['slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value), 'hash_key' => optional($item->hash_key)->code]))
                        <a href="{{ $route }}" title="{{ $route }}" class="text-primary"  target="_blank">
                            <i class="la la-newspaper-o"></i>
                        </a>
                    @endif

                    <a href="javascript:void(0);" class="text-danger" id="btn-delete" data-route="{{ route('admin.jobs.destroy', ['id' => $item->id]) }}">
                        <i class="la la-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $data->appends($search)->links() !!}
@endsection

@section("script")
    <script type="text/javascript">
        function changeStatus(id) {
            $.blockUI({message: ''});
            $.ajax({
                url: route('admin.ajax.jobs.change-status'),
                type:'POST',
                data: {id: id},
                success: function (response) {
                    if (response.code == 204)
                        swal("", response.msg, "error");
                    else if (response.code == 200)
                        swal({
                            type: 'success',
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function (isConfirm) {
                            if (isConfirm)
                                window.location.reload();
                        });

                    $.unblockUI();
                },
                error: function (error) {
                    $.unblockUI();
                }
            });
        }

        $('#table-job').on('click', '#btn-delete', function (event) {
            event.preventDefault();

            let deleteUrl = $(this).data('route');

            swal({
                type: 'warning',
                title: '{{ __('custom.confirm.delete') }}',
                showConfirmButton: true,
                showCancelButton: true,
                timer: 60000,
            }).then(function (isConfirm) {
                if (isConfirm.dismiss == 'cancel' || isConfirm.value != true)
                    return false;

                let form = document.createElement('form');
                form.setAttribute('method', 'POST');
                form.setAttribute('action', deleteUrl);

                let csrfField = document.createElement('input');
                csrfField.setAttribute('type', 'hidden');
                csrfField.setAttribute('name', '_token');
                csrfField.setAttribute('value', $('meta[name="csrf-token"]').attr('content'));
                form.appendChild(csrfField);

                let methodField = document.createElement('input');
                methodField.setAttribute('type', 'hidden');
                methodField.setAttribute('name', '_method');
                methodField.setAttribute('value', 'DELETE');
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }).catch(swal.noop);
        });

        $(function () {
            $("select").select2({});

            $( ".m-datepicker" ).datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                clearBtn: true,
                todayBtn: "linked",
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });
        });
    </script>
@endsection
