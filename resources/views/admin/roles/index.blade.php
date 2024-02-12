@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.roles.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name', 'Tên quyền') !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', old('name', isset($params['name']) ? $params['name'] : null), ['class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
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
            <th>Tên quyền</th>
            <th>Ngày tạo</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->display_name }}</td>
                <td>{{ optional($item->created_at)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.roles.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                        <i class="la la-pencil"></i> {{ __('custom.button.update') }}
                    </a>
                    <a href="{{ route('admin.roles.show', ['id' => $item->id]) }}" class="btn btn-sm btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
                        <i class="la la-key"></i> Xem phân quyền
                    </a>
                    <a href="javascript:void(0);" class="btn btn-sm btn-warning m-btn m-btn--custom m-btn--icon m-btn--air" onclick=" $.blockUI({message:''}); return $('#copy_form_id_{{ $item->id }}').submit();">
                        <i class="la la-copy"></i> {{ __('custom.button.copy') }}
                    </a>
                    <form id="copy_form_id_{{ $item->id }}" method="POST" action="{{ route('admin.roles.copy', ['id' => $item->id]) }}" style="display: none;">{{ csrf_field() }}</form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $data->appends($params)->links() !!}
@endsection

@section("script")
    <script type="text/javascript">
    </script>
@endsection
