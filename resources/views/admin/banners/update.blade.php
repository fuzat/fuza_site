@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.banners.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.banners.update', $id] : ['admin.banners.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($id) ? $lang : env('APP_LOCALE')), ['class' => 'form-control m-input', 'id' => !empty($id) ? 'locale' : '']) !!}
        </div>

        @php($f = $page_setting['attr'].'-name')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'name'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-menu')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $menus, old($f, !empty($id) ? $data->menu_id : ''), ['class' => 'form-control m-select2', 'placeholder' => __('custom.button.choose-menu'),'id' => 'menu-box']) !!}
        </div>

        @php($f = $page_setting['attr'].'-post')
        @if(empty($id))
            <div class="form-group m-form__group" style="display: none;" id="form-post-box">
                <label>{{ __('validation.attributes.'.$f) }}</label>
                {!! Form::select($f, [], old($f, ''), ['class' => 'form-control m-select2', 'placeholder' => __('custom.button.choose-post'), 'id' => 'post-box']) !!}
            </div>
        @else
            @php($menu = \App\Models\Menu::getData($data->menu_id))
            <div class="form-group m-form__group" id="form-post-box" @if(optional($menu)->route_name != 'front.about-us') style="display: none;" @endif>
                <label>{{ __('validation.attributes.'.$f) }}</label>
                {!! Form::select($f, $posts, old($f, $data->post_id), ['class' => 'form-control m-select2', 'placeholder' => __('custom.button.choose-post'), 'id' => 'post-box']) !!}
            </div>
        @endif

        @php($f = $page_setting['attr'].'-position')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $banner_positions, old($f, !empty($id) ? $data->banner_position_id : ''), ['class' => 'form-control m-select2', 'placeholder' => __('custom.button.choose-position'), 'id' => 'position']) !!}
        </div>

        @php($f = $page_setting['attr'].'-file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {{ Form::file($f, ['class' => 'form-control m-input', 'id' => 'media']) }}
            <span class="m-form__help m--valign-top" id="size-web">(1920*740)</span>
            @if(!empty($id) && $media = $data->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER))
                @if(empty($media))
                    @php($media = $data->getLocaleMedia(env('APP_LOCALE'), \App\Models\Media::OBJ_TYPE_BANNER))
                    <img src="{{ !empty($media) ? $media->thumbnail_path : null}}">
                @else
                    <img src="{{ $media->thumbnail_path }}">
                @endif
            @endif
        </div>

        @php($f = $page_setting['attr'].'-mobile_file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {{ Form::file($f, ['class' => 'form-control m-input', 'id' => 'media_mobile']) }}
            <span class="m-form__help m--valign-top" id="size-mobile">(720*400)</span>
            @if(!empty($id) && $media_mobile = $data->getLocaleMedia('', \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))
                @if(empty($media_mobile))
                    @php($media_mobile = $data->getLocaleMedia(env('APP_LOCALE'), \App\Models\Media::OBJ_TYPE_BANNER_MOBILE))
                    <img src="{{ !empty($media_mobile) ? $media_mobile->thumbnail_path : null}}">
                @else
                    <img src="{{ $media_mobile->thumbnail_path }}">
                @endif
            @endif
        </div>

        @php($f = $page_setting['attr'].'-slogan_1')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'slogan_1'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-slogan_2')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'slogan_2'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>URL</label>
            {!! Form::text('url', old('url', !empty($id) ? $data->url : null), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_ACTIVE), ['class' => 'form-control m-input']) !!}
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            {!! Form::submit(__('custom.button.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::reset(__('custom.button.refresh'), ['class' => 'btn btn-secondary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section("script")
    <script type="text/javascript">
        function getPostList(menu_id) {
            $.blockUI({message: ''});
            $.ajax({
                url: route('ajax.posts.get-posts-by-menu'),
                type: 'GET',
                data: {
                    menu_id: menu_id,
                    menu_route_name: 'front.about-us',
                    except_id: '{{ !empty($id) && !empty($data->post_id) ? $data->post_id : null }}',
                },
                success: function (response) {
                    if (response.code == 204) {
                        swal("", response.msg, "error");
                    } else if (response.code == 200) {

                        $('#post-box').html('<option value="">' + '{{ __('custom.button.choose-post') }}' + '</option>');

                        if (Object.keys(response.data).length > 0) {
                            $.each(response.data, function (value, text) {
                                $('#post-box').append($('<option>', {
                                    value: value,
                                    text: text,
                                }));
                            });

                            $('#form-post-box').css('display', 'block');

                            @if(!empty($id) && !empty($data->post_id))
                            $('#post-box').find('option[value=' + {{ $data->post_id }} +']').attr('selected', true);
                            @endif
                        } else {
                            $('#form-post-box').css('display', 'none');
                        }
                    }
                    $.unblockUI();
                },
                error: function (error) {
                    $.unblockUI();
                }
            });
        }

        $(function () {
            let size_web = @json(\App\Models\BannerPosition::_SIZE_WEB);
            let size_mobile = @json(\App\Models\BannerPosition::_SIZE_MOBILE);

            $('.m-select2').select2({width: '100%'});

            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.banners.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            $('#position').on('change', function (e) {
                e.preventDefault();

                $('#size-web').html(size_web[$(this).val()]);
                $('#size-mobile').html(size_mobile[$(this).val()]);
            });

            $('#menu-box').on('change', function (e) {
                e.preventDefault();
                getPostList($(this).val());
            });

            @if(!empty($id))
            $('#menu-box').trigger('change');
            @endif
        });
    </script>
@endsection
