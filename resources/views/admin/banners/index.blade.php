@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.banners.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name', __('validation.attributes.'.$page_setting['attr'].'-name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', old('name', isset($search['name']) ? $search['name'] : null), ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('menu', __('validation.attributes.'.$page_setting['attr'].'-menu')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('menu', $menus, old('menu', isset($search['menu']) ? $search['menu'] : null), ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('position', __('validation.attributes.'.$page_setting['attr'].'-position')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('position', $banner_positions, old('position', isset($search['position']) ? $search['position'] : null), ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status',  __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.status'), old('status', isset($search['status']) ? $search['status'] : null), ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air"><i class="la la-filter"></i> {{ __('custom.button.filter') }}</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air"><i class="la la-refresh"></i> {{ __('custom.button.refresh') }}</a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-banner">
        <thead>
        <tr>
            <th>ID</th>
            <th>{{  __('validation.attributes.'.$page_setting['attr'].'-name') }}</th>
            <th>{{  __('validation.attributes.'.$page_setting['attr'].'-menu') }}</th>
            <th>{{  __('validation.attributes.'.$page_setting['attr'].'-post') }}</th>
            <th>{{  __('validation.attributes.'.$page_setting['attr'].'-position') }}</th>
            <th>{{  __('validation.attributes.'.$page_setting['attr'].'-file') }}</th>
            <th>{{ __('validation.attributes.locale') }}</th>
            <th>{{  __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if($data->total())
            @php($banner_positions = \App\Models\BannerPosition::getAll())
            @foreach($data as $i => $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ strip_tags(optional($item->datameta('', 'name'))->data_value) }}</td>
                    <td>
                        @if($item->menu_id == -1)
                            {{ __('datametas.web.title.home') }}
                        @elseif($item->menu_id == -2)
                            {{ __('datametas.web.title.search') }}
                        @elseif($item->menu_id == -3)
                            {{ __('datametas.web.title.join-talent-community') }}
                        @else
                            {{ !empty($item->menu) ? strip_tags(optional($item->menu->datameta('', 'name'))->data_value) : null }}
                        @endif
                    </td>
                    <td>{{ !empty($item->post) ? strip_tags(optional($item->post->datameta('', 'title'))->data_value) : null }}</td>
                    <td>{{ !empty($item->banner_position_id) && !empty($banner_positions) ? $banner_positions[$item->banner_position_id] : null }}</td>
                    <td>
                        @php($media = $item->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))
                        <img src="{{ !empty($media) ? asset($media->thumbnail_path) : null }}">
                    </td>
                    <td>
                        @foreach(\App\Models\Datameta::getExistLanguages(['type' => \App\Models\Datameta::TYPE_BANNER, 'id' => $item->id, 'field' => 'name']) as $k => $language)
                            @php($lang = str_replace('name_', '', $language->data_field))
                            <a href="{{ route('admin.banners.edit', ['id' => $item->id, 'lang' => $lang]) }}">
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
                        <a href="{{ route('admin.banners.edit', ['id' => $item->id]) }}" class="btn btn-accent m-btn m-btn--icon m-btn--air">
                            <i class="la la-pencil"></i>  {{ __('custom.button.update') }}
                        </a>
                        <button class="btn btn-danger m-btn m-btn--icon m-btn--air" id="btn-delete" data-route="{{ route('admin.banners.destroy', ['id' => $item->id]) }}">
                            <i class="la la-trash"></i>  {{ __('custom.button.delete') }}
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
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
                url: route('admin.ajax.banners.change-status'),
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

        $('#table-banner').on('click', '#btn-delete', function (event) {
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
