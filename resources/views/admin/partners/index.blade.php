@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.partners.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name', __('validation.attributes.'.$page_setting['attr'].'-name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', isset($search['name']) ? $search['name'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        {{--<div class="col-md-4">--}}
            {{--<div class="m-form__label">--}}
                {{--{!! Form::label('url', __('validation.attributes.'.$page_setting['attr'].'-url')) !!}--}}
            {{--</div>--}}
            {{--<div class="m-form__control">--}}
                {{--{!! Form::text('url', isset($search['url']) ? $search['url'] : null, ['class' => 'form-control m-input']) !!}--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status', __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.status'), isset($search['status']) ? $search['status'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('validation.attributes.' . $page_setting['attr'].'-file') }}</th>
            <th>{{ __('validation.attributes.' . $page_setting['attr'].'-name') }}</th>
{{--            <th>{{ __('validation.attributes.' . $page_setting['attr'].'-url') }}</th>--}}
            <th>{{ __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>
                    <i>{{ ($i + 1) }}</i>
                </td>
                <td>
                    <img src="{{ !empty($item->media) ? asset($item->media->thumbnail_path) : null }}">
                </td>
                <td>
                    {{ strip_tags($item->name) }}
                </td>
                {{--<td>--}}
                    {{--<a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a>--}}
                {{--</td>--}}
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
                <td class="">
                    <a href="{{ route('admin.partners.edit', ['id' => $item->id]) }}" class="btn btn-accent m-btn m-btn--icon m-btn--air">
                        <i class="la la-pencil"></i>  {{ __('custom.button.update') }}
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.partners.destroy', $item->id], 'id' => 'form-delete', 'onsubmit' => 'return confirm("'.__('custom.confirm.delete').'");']) !!}
                    <button class="btn btn-danger m-btn m-btn--icon m-btn--air">
                        <i class="la la-trash"></i> {{ __('custom.button.delete') }}
                    </button>
                    {!! Form::close() !!}
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
        function changeStatus(id) {
            $.blockUI({message: ''});
            $.ajax({
                url: route('admin.ajax.partners.change-status'),
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
                        });

                    $.unblockUI();
                },
                error: function (error) {
                    $.unblockUI();
                }
            });
        }
    </script>
@endsection
