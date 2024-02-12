@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    @php($f = !empty($page_setting) ? $page_setting['attr'] . '-' : \App\Models\News::_ATTR . '-')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.news.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('name', __('validation.attributes.'. $f .'name')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('name', isset($search['name']) ? $search['name'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('slug', __('validation.attributes.'. $f .'slug')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('slug', isset($search['slug']) ? $search['slug'] : null, ['class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('category', __('validation.attributes.'. $f .'category')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('category', $categories, isset($search['category']) ? $search['category'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('hot_news', __('validation.attributes.hot_news')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('hot_news', __('datametas.select-box.hot_news'), isset($search['hot_news']) ? $search['hot_news'] : null, ['placeholder' => __('custom.button.select-all'), 'class' => 'form-control m-input']) !!}
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
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-news">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('validation.attributes.'. $f .'name') }}</th>
            <th>{{ __('validation.attributes.'. $f .'file-big') }}</th>
            <th>{{ __('validation.attributes.'. $f .'file-large') }}</th>
            <th>{{ __('validation.attributes.'. $f .'category') }}</th>
            <th>{{ __('validation.attributes.'. $f .'content') }}</th>
            <th>{{ __('validation.attributes.'. $f .'public_date') }}</th>
            <th>{{ __('validation.attributes.hot_news') }}</th>
            <th>{{ __('validation.attributes.locale') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td><i>{{ ($i + 1) }}</i></td>
                <td>{{ Illuminate\Support\Str::limit(strip_tags(optional($item->datameta('', 'name'))->data_value), 50) }}</td>
                <td><img src="{{ !empty($item->media_big) ? asset($item->media_big->thumbnail_path) : null }}"></td>
                <td><img src="{{ !empty($item->media_detail) ? asset($item->media_detail->thumbnail_path) : null }}"></td>
                <td>{{ $item->category ? strip_tags(optional($item->category->datameta('', 'name'))->data_value) : null }}</td>
                <td>{{ Illuminate\Support\Str::limit(strip_tags(optional($item->datameta('', 'content'))->data_value), 50) }}</td>
                <td>{{ !empty($item->public_date) ? \Carbon\Carbon::parse($item->public_date)->format('d/m/Y') : null }}</td>
                <td>{{ __('datametas.select-box.hot_news')[$item->hot_news] }}</td>
                <td>
                    @foreach(\App\Models\Datameta::getExistLanguages(['type' => \App\Models\Datameta::TYPE_NEWS, 'id' => $item->id, 'field' => 'name']) as $k => $language)
                        @php($lang = str_replace('name_', '', $language->data_field))
                        <a href="{{ route('admin.news.edit', ['id' => $item->id, 'lang' => $lang]) }}">
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
                    <a href="{{ route('admin.news.edit', ['id' => $item->id]) }}" class="text-warning" title="{{ __('custom.button.update') }}">
                        <i class="la la-pencil"></i>
                    </a>

                    <a href="{{ route('admin.news.show', ['id' => $item->id]) }}" class="text-info" title="{{ __('custom.button.show') }}">
                        <i class="la la-eye"></i>
                    </a>

                    @if($item->status == \App\Models\Constant::STATUS_ACTIVE)
                        @php($route = route('front.news.show', ['slug' => Illuminate\Support\Str::slug(optional($item->datameta('', 'name'))->data_value), 'hash_key' => optional($item->hash_key)->code]))
                        <a href="{{ $route }}" title="{{ $route }}" class="text-primary"  target="_blank">
                            <i class="la la-newspaper-o"></i>
                        </a>
                    @endif

                    <a href="javascript:void(0);" title="{{ __('custom.button.delete') }}" class="text-danger" id="btn-delete" data-route="{{ route('admin.news.destroy', ['id' => $item->id]) }}">
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
                url: route('admin.ajax.news.change-status'),
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

        $('#table-news').on('click', '#btn-delete', function (event) {
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
