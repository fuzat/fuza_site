@extends("admin.layout.table")

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.contacts.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('email', 'Email') !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('email', isset($search['email']) ? $search['email'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('fullname', __('validation.attributes.fullname')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('fullname', isset($search['fullname']) ? $search['fullname'] : null, ['class' => 'form-control m-input']) !!}
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
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-contact">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('validation.attributes.fullname') }}</th>
            <th>{{ __('validation.attributes.email') }}</th>
            <th>{{ __('validation.attributes.phone') }}</th>
            <th>{{ __('validation.attributes.message') }}</th>
            <th>{{ __('validation.attributes.created_at') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ ($i + 1) }}</td>
                <td>{{ $item->fullname }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->content }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>
                    <button class="btn btn-secondary m-btn m-btn--icon">
                        {{ __('datametas.select-box.contact')[$item->status] }}
                    </button>
                    @if($item->status == \App\Models\Contact::_STATUS_NEW)
                        <button class="btn btn-outline-success m-btn m-btn--wide btn-sm" data-url="{{ route('admin.ajax.contacts.change-status') }}" id="status" data-id="{{ $item->id }}" data-status="{{ \App\Models\Contact::_STATUS_DONE }}">
                            <span class="m-nav__link-text">{{ __('datametas.select-box.contact')[\App\Models\Contact::_STATUS_DONE] }}</span>
                        </button>
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
        $('button#status').on('click', function () {
            $.blockUI({message: ''});
            $.ajax({
                url: route('admin.ajax.contacts.change-status'),
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

        $('#table-contact').on('click', '#btn-delete', function (event) {
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
