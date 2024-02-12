@extends("admin.layout.table")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-plus"></i> {{ __('custom.button.create') }}
        </a>
    </div>
@endsection

@section('search')
    @php($f = !empty($page_setting) ? $page_setting['attr'] . '-' : \App\Models\Post::_ATTR . '-')
    {!! Form::open(['method' => 'GET', 'route' => ['admin.posts.index'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="form-group m-form__group row align-items-center">
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('menu', __('validation.attributes.'. $f .'menu')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('menu', $menus, isset($search['menu']) ? $search['menu'] : null, ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('status', __('validation.attributes.status')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::select('status', __('datametas.select-box.status'), isset($search['status']) ? $search['status'] : null, ['placeholder' => __('datametas.select-box.all'), 'class' => 'form-control m-input']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-form__label">
                {!! Form::label('title', __('validation.attributes.'. $f .'title')) !!}
            </div>
            <div class="m-form__control">
                {!! Form::text('title', isset($search['title']) ? $search['title'] : null, ['class' => 'form-control m-input']) !!}
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
    </div>
    <div class="col-xl-4 order-1 order-xl-2">
        <button type="submit" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-filter"></i> {{ __('custom.button.filter') }}
        </button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
            <i class="la la-refresh"></i> {{ __('custom.button.reset') }}
        </a>
    </div>
    {!! Form::close() !!}
@endsection

@section('list')
    <table class="table m-table m-table--head-separator-primary" id="table-post">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('validation.attributes.'. $f .'title') }}</th>
            <th>{{ __('validation.attributes.'. $f .'type') }}</th>
            <th>{{ __('validation.attributes.'. $f .'menu') }}</th>
            <th>{{ __('validation.attributes.'. $f .'short-content') }}</th>
            <th>{{ __('validation.attributes.'. $f .'seo_title') }}</th>
            <th>{{ __('validation.attributes.'. $f .'seo_description') }}</th>
            <th>{{ __('validation.attributes.locale') }}</th>
            <th>{{ __('validation.attributes.status') }}</th>
            <th width="80"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $i => $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ strip_tags(optional($item->datameta('', 'title'))->data_value) }}</td>
                <td>{{ !empty($item->type) ? __('datametas.select-box.post-type')[$item->type] : null }}</td>
                <td>{{ $item->menu ? strip_tags(optional($item->menu->datameta('', 'name'))->data_value) : null }}</td>
                <td>{{ strip_tags(optional($item->datameta('', 'short-content'))->data_value) }}</td>
                <td>{{ strip_tags(optional($item->datameta('', 'seo_title'))->data_value) }}</td>
                <td>{{ Illuminate\Support\Str::limit(strip_tags(optional($item->datameta('', 'seo_description'))->data_value), 100) }}</td>
                <td>
                    @foreach(\App\Models\Datameta::getExistLanguages(['type' => \App\Models\Datameta::TYPE_POST, 'id' => $item->id, 'field' => 'title']) as $k => $language)
                        @php($lang = str_replace('title_', '', $language->data_field))
                        <a href="{{ route('admin.posts.edit', ['id' => $item->id, 'lang' => $lang]) }}">
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
                    <a href="{{ route('admin.posts.edit', ['id' => $item->id]) }}" class="text-warning" title="{{ __('custom.button.update') }}">
                        <i class="la la-pencil"></i>
                    </a>

                    @if($item->status == \App\Models\Constant::STATUS_ACTIVE)
                        @if($item->type == \App\Models\Post::_TYPE_HOME)
                            @php($route = route('front.home'))
                        @else
                            @if(optional($item->menu)->route_name == 'front.contact')
                                @php($route = route('front.contact'))
                            @elseif(optional($item->menu)->route_name == 'front.about-us')
                                @php($route = route('front.about-us', ['hash_key' => optional($item->hash_key)->code, 'slug' => optional($item->datameta(env('APP_LOCALE'), 'slug'))->data_value]))
                            @else
                                @php($route = route('front.post.index', ['hash_key' => encrypt($item->id)]))
                            @endif
                        @endif

                        <a href="{{ $route }}" title="{{ $route }}" class="text-info"  target="_blank">
                            <i class="la la-newspaper-o"></i>
                        </a>
                    @endif

                    <a href="javascript:void(0);" id="btn-delete" data-route="{{ route('admin.posts.destroy', ['id' => $item->id]) }}" class="text-danger" title="{{ __('custom.button.delete') }}">
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
                url: route('admin.ajax.posts.change-status'),
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

        $('#table-post').on('click', '#btn-delete', function (event) {
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
