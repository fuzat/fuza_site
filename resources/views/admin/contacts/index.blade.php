@extends("admin.layout.table")

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.contacts.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('email', 'Email') !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('email', isset($params['email']) ? $params['email'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('fullname', __('validation.attributes.fullname')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('fullname', isset($params['fullname']) ? $params['fullname'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status', __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.contact'),
                isset($params['status']) ? $params['status'] : null,
                ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
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
    <table class="table m-table m-table--head-separator-primary">
        <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Tin nhắn</th>
            <th>Ngày tạo</th>
            <th>Trạng thái</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ $item->id }}</td>
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
                        @permission('admin.contacts.edit')
                        <button class="btn btn-outline-success m-btn m-btn--wide btn-sm"
                                data-url="{{ route('admin.ajax.contacts.change-status') }}" id="status"
                                data-id="{{ $item->id }}" data-status="{{ \App\Models\Contact::_STATUS_DONE }}">
                            <span class="m-nav__link-text">Đã xử lý</span>
                        </button>
                        @endpermission
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="float-right">
        {!! $data->appends($params)->links() !!}
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
    </script>
@endsection
