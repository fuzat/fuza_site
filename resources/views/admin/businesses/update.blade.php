@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.businesses.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.businesses.update', $id] : ['admin.businesses.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($id) ? $lang : env('APP_LOCALE')), ['class' => 'form-control m-input', 'id' => !empty($id) ? 'locale' : null]) !!}
        </div>

        @php($f = $page_setting['attr'].'-name')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'name'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-avatar')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} {{-- <span class="text-danger">(*)</span> --}}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(65*65)</span>
            @if(!empty($id) && $data->avatar)
                <img src="{{ $data->avatar->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} {{-- <span class="text-danger">(*)</span> --}}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(585*300)</span>
            @if(!empty($id) && $data->file)
                <img src="{{ $data->file->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-short-desc')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'short-desc'))->data_value : null), ['class' => 'form-control m-input', 'rows' => '5']) !!}
        </div>

        @php($f = $page_setting['attr'].'-content')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'content'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'content']) !!}
        </div>

        @php($f = $page_setting['attr'].'-scale-operation')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'scale-operation'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'scale-operation']) !!}
        </div>

        @php($f = $page_setting['attr'].'-development-strategy')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'development-strategy'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'development-strategy']) !!}
        </div>

        @php($f = $page_setting['attr'].'-our-products')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'our-products'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'our-products']) !!}
        </div>

        @php($f = $page_setting['attr'].'-products-background')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(1920*535)</span>
            @if(!empty($id) && $data->products_background)
                <img src="{{ $data->products_background->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-all-products-url')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? $data->all_products_url : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-show-home')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, __('datametas.select-box.show-home'), old($f, !empty($id) ? $data->show_home : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input', 'id' => 'show-home']) !!}
        </div>

        @php($f = $page_setting['attr'].'-icon')
        <div class="form-group m-form__group" id="icon-inactive">
            <label>{{ __('validation.attributes.'.$f) }} {{-- <span class="text-danger">(*)</span> --}}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(65*65)</span>
            @if(!empty($id) && $data->icon)
                <img src="{{ $data->icon->thumbnail_path }}">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-icon-act')
        <div class="form-group m-form__group" id="icon-active">
            <label>{{ __('validation.attributes.'.$f) }} {{-- <span class="text-danger">(*)</span> --}}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(65*65)</span>
            @if(!empty($id) && $data->icon_act)
                <img src="{{ $data->icon_act->thumbnail_path }}" style="background-color: #C8E9E7;">
            @endif
        </div>

        @php($f = $page_setting['attr'].'-file-home')
        <div class="form-group m-form__group" id="file-home">
            <label>{{ __('validation.attributes.'.$f) }} {{-- <span class="text-danger">(*)</span> --}}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top">(665*667)</span>
            @if(!empty($id) && $data->file_home)
                <img src="{{ $data->file_home->thumbnail_path }}">
            @endif
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            {!! Form::submit(__('custom.button.save'), ['class' => 'btn btn-primary', 'onclick' => "$.blockUI({message: ''});",]) !!}
            {!! Form::reset(__('custom.button.reset'), ['class' => 'btn btn-secondary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section("script")
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        function displayShowHome(show_home) {
            if (show_home == '{{ \App\Models\Constant::STATUS_ACTIVE }}') {
                $('#icon-active').css('display', 'block');
                $('#icon-inactive').css('display', 'block');
                $('#file-home').css('display', 'block');
                $('#short-desc').css('display', 'block');
            } else {
                $('#icon-active').css('display', 'none');
                $('#icon-inactive').css('display', 'none');
                $('#file-home').css('display', 'none');
                $('#short-desc').css('display', 'none');
            }
        }

        $(function () {
            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.businesses.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            CKEDITOR.replace('content', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('scale-operation', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('development-strategy', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('our-products', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });

            if (typeof CKEDITOR != 'undefined') {
                $('form').on('reset', function(e) {
                    if ($(CKEDITOR.instances).length) {
                        for (var key in CKEDITOR.instances) {
                            var instance = CKEDITOR.instances[key];
                            if ($(instance.element.$).closest('form').attr('name') == $(e.target).attr('name')) {
                                instance.setData(instance.element.$.defaultValue);
                            }
                        }
                    }
                });
            }

            let show_home = $('#show-home');

            displayShowHome(show_home.val());

            show_home.on('change', function (e) {
                e.preventDefault();
                displayShowHome($(this).val());
            })
        });
    </script>
@endsection
