@extends("admin.layout.table")

@section('search')
    @php($f = \App\Models\Application::_ATTR . '-')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.applications.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name', __('validation.attributes.'.$f.'name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', isset($search['name']) ? $search['name'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('email', __('validation.attributes.'.$f.'email')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('email', isset($search['email']) ? $search['email'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('position', __('validation.attributes.'.$f.'position')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('position', isset($search['position']) ? $search['position'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('company', __('validation.attributes.'.$f.'company')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('company', $companies, isset($search['company']) ? $search['company'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input', 'id' => 'company']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('company_location', __('validation.attributes.'.$f.'company_location')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('company_location', [], isset($search['company_location']) ? $search['company_location'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input', 'id' => 'company_location']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status', __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.contact'), isset($search['status']) ? $search['status'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('job_type', __('validation.attributes.jobs-type')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('job_type', $job_types, isset($search['job_type']) ? $search['job_type'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('job_level', __('validation.attributes.jobs-level')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('job_level', $job_levels, isset($search['job_level']) ? $search['job_level'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-application">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('validation.attributes.'.$f.'name') }}</th>
            <th>{{ __('validation.attributes.'.$f.'email') }}</th>
            <th>{{ __('validation.attributes.'.$f.'mobile') }}</th>
            <th>{{ __('validation.attributes.'.$f.'position') }}</th>
            <th>{{ __('validation.attributes.'.$f.'company') }}</th>
            <th>{{ __('validation.attributes.'.$f.'company_location') }}</th>
            <th>{{ __('validation.attributes.created_at') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th>{{ __('validation.attributes.'.$f.'cv_file') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ ($i + 1) }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->mobile }}</td>
                <td>{{ $item->position }}</td>
                <td>{{ !empty($item->company) ? optional($item->company->datameta('', 'name'))->data_value : null }}</td>
                <td>
                    @if(!empty($item->company_location))
                        @php($work_place = optional($item->company_location->datameta('', 'city'))->data_value. ' : '.optional($item->company_location->datameta('', 'address'))->data_value)
                    @endif
                    {{ $work_place }}
                </td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>
                    <button class="btn btn-secondary m-btn m-btn--icon">
                        {{ __('datametas.select-box.contact')[$item->status] }}
                    </button>
                    @if($item->status == \App\Models\Contact::_STATUS_NEW)
                        <button class="btn btn-outline-success m-btn m-btn--wide btn-sm" data-url="{{ route('admin.ajax.applications.change-status') }}" id="status" data-id="{{ $item->id }}" data-status="{{ \App\Models\Contact::_STATUS_DONE }}">
                            <span class="m-nav__link-text">{{ __('datametas.select-box.contact')[\App\Models\Contact::_STATUS_DONE] }}</span>
                        </button>
                    @endif
                </td>
                <td>
                    @if(!empty($item->cv_file))
                        <a href="{{ asset($item->cv_file) }}" target="_blank" download class="text-success" title="{{ __('custom.button.download-cv') }}">
                            <i class="la la-download"></i>
                        </a>
                    @endif
                </td>
                <td>
                    <button class="btn btn-danger m-btn m-btn--icon m-btn--air" id="btn-delete" data-route="{{ route('admin.applications.destroy', ['id' => $item->id]) }}">
                        <i class="la la-trash"></i>  {{ __('custom.button.delete') }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="float-right">
        {!! $data->appends($search)->links() !!}
    </div>
@endsection

@section("script")
    <script type="text/javascript">
        $('table').on('click', '#status', function () {
            $.blockUI({message: ''});
            $.ajax({
                url: route('admin.ajax.applications.change-status'),
                type:'POST',
                data: {
                    id: $(this).data('id'),
                    status: $(this).data('status'),
                },
                success: function (response) {
                    if (response.code == 204) {
                        swal("", response.msg, "error");
                        $.unblockUI();
                    } else if (response.code == 200) {
                        swal({
                            type: 'success',
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function (error) {
                    $.unblockUI();
                }
            });
        });

        $('#company').on('change', function (e) {
            e.preventDefault();

            $.blockUI({message: ''});

            $.ajax({
                url: '{{ route('ajax.applications.get-company-location') }}',
                method: 'GET',
                data: {'company_id': $(this).val()},
                success: function (response) {
                    if (response.code == 204) {
                        swal("", response.msg, "error");
                        $.unblockUI();
                    } else if (response.code == 200) {
                        $('#company_location').html('<option value="">{{ __('custom.button.select-all') }}</option>');
                        $.each(response.data, function (id, name) {
                            $('#company_location').append($('<option>', {
                                value: id,
                                text: name,
                            }));
                        });
                    }

                    $.unblockUI();
                },
                error: function (err) {
                    $.unblockUI();
                }
            });
        });

        @if(isset($search['company']) && !empty($search['company']))
        $.blockUI({message: ''});

        $.ajax({
            url: '{{ route('ajax.applications.get-company-location') }}',
            method: 'GET',
            data: {'company_id': '{{ $search['company'] }}'},
            success: function (response) {
                if (response.code == 204) {
                    swal("", response.msg, "error");
                    $.unblockUI();
                } else if (response.code == 200) {
                    $('#company_location').html('<option value="">{{ __('custom.button.select-all') }}</option>');
                    $.each(response.data, function (id, name) {
                        $('#company_location').append($('<option>', {
                            value: id,
                            text: name,
                        }));
                    });
                }

                $.unblockUI();
            },
            error: function (err) {
                $.unblockUI();
            }
        });
        @endif

        $('#table-application').on('click', '#btn-delete', function (event) {
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
    </script>
@endsection
