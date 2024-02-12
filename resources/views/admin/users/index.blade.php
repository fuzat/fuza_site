@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => 'admin.users.index', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name',  __('validation.attributes.'.$page_setting['attr'].'-name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', \Input::get('name'), ['placeholder' => '', 'class' => 'form-control m-input']) !!}
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
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('role', __('validation.attributes.'.$page_setting['attr'].'-role')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('role', $role_arr, \Input::get('role'), ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
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
            <th>Tên người dùng</th>
            <th>Phân quyền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    @if (!empty($t = $item->roles))
                        @foreach ($t as $v)
                            {{ $v->display_name }}<br>
                        @endforeach
                    @endif
                </td>
                <td>
                    <div id="bootstrap-switch-status" class="bootstrap-switch bootstrap-switch-custom bootstrap-switch-wrapper bootstrap-switch-animate" data-id="{{ $item->id }}">
                        <input data-switch="true" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }} data-on-color="brand" id="m_notify_dismiss">
                    </div>
                </td>
                <td class="">
                    <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                        <i class="la la-pencil"></i> {{ __('custom.button.update') }}
                    </a>
                    <a href="javascript:void(0);" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--air" onclick="$.blockUI({message:''}); return $('#reset_form_id_{{ $item->id }}').submit();">
                        <i class="la la-key"></i> {{ __('custom.button.reset-password') }}
                    </a>
                    <form id="reset_form_id_{{ $item->id }}" method="POST" action="{{ route('admin.users.reset-password', ['id' => $item->id]) }}" style="display: none;">{{ csrf_field() }}</form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $data->appends($params)->links() !!}
@endsection

@section("script")
    <script type="text/javascript" src="{{ asset("assets/demo/default/custom/components/base/bootstrap-notify.js") }}"></script>
    <script type="text/javascript">
        $('div.bootstrap-switch-custom').on('switchChange.bootstrapSwitch', function (event, state) {
            $.blockUI({message: ''});
            $.ajax({
                url: route('admin.ajax.users.change-status'),
                type:'POST',
                data: {
                    id: $(this).data('id'),
                    status: state,
                },
                success: function (response) {
                    // console.log(response);
                    if (response.code == 204)
                        swal("", response.msg, "error");
                    else if (response.code == 200)
                        swal({
                            type: 'success',
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    $.unblockUI();
                },
                error: function (error) {
                    $.unblockUI();
                }
            });
        });
    </script>
@endsection
