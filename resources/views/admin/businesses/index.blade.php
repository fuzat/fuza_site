@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.businesses.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    @php($f = 'validation.attributes.' . \App\Models\Business::_ATTR .'-')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.businesses.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name', __($f . 'name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', isset($search['name']) ? $search['name'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('slug', __($f . 'slug')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('slug', isset($search['slug']) ? $search['slug'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('show_home', __($f.'show-home')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('show_home', __('datametas.select-box.show-home'), isset($search['show_home']) ? $search['show_home'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
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
        <a href="{{ route('admin.businesses.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-business">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __($f . 'name') }}</th>
            <th>{{ __($f . 'avatar') }}</th>
            <th>{{ __($f . 'file') }}</th>
            <th>{{ __($f . 'icon') }}</th>
            <th>{{ __($f . 'file-home') }}</th>
            <th>{{ __($f . 'show-home') }}</th>
            <th>{{ __('validation.attributes.locale') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td><i>{{ ($i + 1) }}</i></td>
                <td>{{ strip_tags(optional($item->datameta('', 'name'))->data_value) }}</td>
                <td><img src="{{ !empty($item->avatar) ? asset($item->avatar->thumbnail_path) : null }}"></td>
                <td><img src="{{ !empty($item->file) ? asset($item->file->thumbnail_path) : null }}"></td>
                <td><img src="{{ !empty($item->icon) ? asset($item->icon->thumbnail_path) : null }}"></td>
                <td><img src="{{ !empty($item->file_home) ? asset($item->file_home->thumbnail_path) : null }}"></td>
                <td>{{ __('datametas.select-box.show-home')[$item->show_home] }}</td>
                <td>
                    @foreach(\App\Models\Datameta::getExistLanguages(['type' => \App\Models\Datameta::TYPE_BUSINESS, 'id' => $item->id, 'field' => 'name']) as $k => $language)
                        @php($lang = str_replace('name_', '', $language->data_field))
                        <a href="{{ route('admin.businesses.edit', ['id' => $item->id, 'lang' => $lang]) }}">
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
                    <a href="{{ route('admin.businesses.edit', ['id' => $item->id]) }}" class="text-warning" title="{{ __('custom.button.update') }}">
                        <i class="la la-pencil"></i>
                    </a>

                    <a href="{{ route('admin.businesses.show', ['id' => $item->id]) }}" class="text-info" title="{{ __('custom.button.show') }}">
                        <i class="la la-eye"></i>
                    </a>

                    @if($item->status == \App\Models\Constant::STATUS_ACTIVE)
                        @php($route = route('front.our-business.show', ['slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value), 'hash_key' => optional($item->hash_key)->code]))
                        <a href="{{ $route }}" title="{{ $route }}" class="text-primary"  target="_blank">
                            <i class="la la-newspaper-o"></i>
                        </a>
                    @endif

                    <a href="javascript:void(0);" title="{{ __('custom.button.delete') }}" class="text-danger" id="btn-delete" data-route="{{ route('admin.businesses.destroy', ['id' => $item->id]) }}">
                        <i class="la la-trash"></i>
                    </a>
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
                url: route('admin.ajax.businesses.change-status'),
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

        $('#table-business').on('click', '#btn-delete', function (event) {
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
