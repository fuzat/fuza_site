@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
        <a href="{{ route('admin.menus.sorting', ['sort' => -1]) }}" class="btn btn-default m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-sort"></i> {{ __('custom.button.sort') }}
        </a>
    </div>
@endsection

@section('search')

    @php($f = $page_setting['attr'] . '-')

    {!! Form::open(['method' => 'GET', 'route' => ['admin.menus.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name',  __('validation.attributes.'. $f .'name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', isset($search['name']) ? $search['name'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('parent_id',  __('validation.attributes.'. $f .'parent_id')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('parent_id', $parents, isset($search['parent_id']) ? $search['parent_id'] : null, ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status',  __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.status'), isset($search['status']) ? $search['status'] : null, ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
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
            <th>{{ __('validation.attributes.'. $f .'name') }}</th>
            <th>{{ __('validation.attributes.'. $f .'parent_id') }}</th>
            <th>{{ __('validation.attributes.locale') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ ($i + 1) }}</td>
                <td>{{ strip_tags(optional($item->datameta('', 'name'))->data_value) }}</td>
                <td>{{ !empty($item->parent) ? strip_tags(optional($item->parent->datameta('', 'name'))->data_value) : null }}</td>
                <td>
                    @foreach(\App\Models\Datameta::getExistLanguages(['type' => \App\Models\Datameta::TYPE_MENU, 'id' => $item->id, 'field' => 'name']) as $k => $language)
                        @php($lang = str_replace('name_', '', $language->data_field))
                        <a href="{{ route('admin.menus.edit', ['id' => $item->id, 'lang' => $lang]) }}">
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
                <td class="">
                    <a href="{{ route('admin.menus.edit', ['id' => $item->id]) }}" class="btn btn-accent m-btn m-btn--icon m-btn--air">
                        <i class="la la-pencil"></i> {{ __('custom.button.update') }}
                    </a>
                    @if($item->route_name == 'front.about-us' && $item->posts()->where('status', \App\Models\Constant::STATUS_ACTIVE)->count())
                        <a href="{{ route('admin.menus.sorting', ['sort' => $item->id, 'type' => 'post']) }}" class="btn btn-default m-btn m-btn--custom m-btn--icon m-btn--air">
                            <i class="la la-sort"></i> {{ __('custom.button.sort') }}
                        </a>
                    @endif
                    @if($item->route_name == 'front.our-business.index' && \App\Models\Business::getList(['count' => true]))
                        <a href="{{ route('admin.menus.sorting', ['sort' => $item->id, 'type' => 'business']) }}" class="btn btn-default m-btn m-btn--custom m-btn--icon m-btn--air">
                            <i class="la la-sort"></i> {{ __('custom.button.sort') }}
                        </a>
                    @endif
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
                url: route('admin.ajax.menus.change-status'),
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
