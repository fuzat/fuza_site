@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.posts.update', 'id' => $id] : ['admin.posts.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($lang) ? $lang : null), ['class' => 'form-control m-input', 'id' => !empty($lang) ? 'locale' : null]) !!}
        </div>

        @php($f = $page_setting['attr'].'-title')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'title'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-type')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $types, old($f, !empty($id) ? $data->type : \App\Models\Post::_TYPE_POST), ['class' => 'form-control m-input', 'id' => 'type']) !!}
        </div>

        @php($f = $page_setting['attr'].'-menu')
        <div class="form-group m-form__group" id="menu">
            <label>{{ __('validation.attributes.'.$f) }} <span class="text-danger">(*)</span></label>
            {!! Form::select($f, $menus, old($f, !empty($id) ? $data->menu_id : null), ['class' => 'form-control m-input', 'placeholder' => __('custom.button.choose-menu'), 'id' => 'input-menu']) !!}
        </div>

        @php($f = $page_setting['attr'].'-page')
        <div class="form-group m-form__group" style="display: none;" id="form-page">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::select($f, \App\Models\Post::getArrayPage(), old($f, !empty($id) ? $data->page : ''), ['class' => 'form-control m-input', 'placeholder' => __('custom.button.choose-page'), 'id' => 'page-box']) !!}
        </div>

        @php($f = $page_setting['attr'].'-short-content')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'short-content'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-content')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'content'))->data_value : null), ['class' => 'form-control m-input', 'id' => 'content']) !!}
        </div>

        @php($f = $page_setting['attr'].'-file')
        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::file($f, ['class' => 'form-control m-input']) !!}
            <span class="m-form__help m--valign-top" id="img-size">(689*469)</span>
            @if(!empty($id) && $data->media)
                @if($data->media->type == \App\Models\Media::_TYPE_IMAGE)
                    <img src="{{ $data->media->thumbnail_path }}">
                @elseif($data->media->type == \App\Models\Media::_TYPE_FILE)
                    <br>
                    <span class="m-form__help m--valign-top">File: {{ $data->media->name }}</span>
                @endif
            @endif
        </div>

        {{--@php($f = $page_setting['attr'].'-vision-mission')--}}
        {{--<div class="form-group m-form__group">--}}
            {{--<label>{{ __('validation.attributes.'.$f) }}</label>--}}
            {{--{!! Form::select($f, __('datametas.select-box.status'), old($f, !empty($id) ? $data->is_vision_mission : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}--}}
        {{--</div>--}}

        {{--@php($f = $page_setting['attr'].'-board-director')--}}
        {{--<div class="form-group m-form__group">--}}
            {{--<label>{{ __('validation.attributes.'.$f) }}</label>--}}
            {{--{!! Form::select($f, __('datametas.select-box.status'), old($f, !empty($id) ? $data->is_board_director : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}--}}
        {{--</div>--}}

        {{--@php($f = $page_setting['attr'].'-core-value')--}}
        {{--<div class="form-group m-form__group">--}}
            {{--<label>{{ __('validation.attributes.'.$f) }}</label>--}}
            {{--{!! Form::select($f, __('datametas.select-box.status'), old($f, !empty($id) ? $data->is_core_value : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}--}}
        {{--</div>--}}

        {{--@php($f = $page_setting['attr'].'-milestone')--}}
        {{--<div class="form-group m-form__group">--}}
            {{--<label>{{ __('validation.attributes.'.$f) }}</label>--}}
            {{--{!! Form::select($f, __('datametas.select-box.status'), old($f, !empty($id) ? $data->is_milestone : \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}--}}
        {{--</div>--}}

        @php($f = $page_setting['attr'].'-seo_title')
        <div class="form-group m-form__group" id="seo_title">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::text($f, old($f, !empty($id) ? optional($data->datameta($lang, 'seo_title'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @php($f = $page_setting['attr'].'-seo_description')
        <div class="form-group m-form__group" id="seo_description">
            <label>{{ __('validation.attributes.'.$f) }}</label>
            {!! Form::textarea($f, old($f, !empty($id) ? optional($data->datameta($lang, 'seo_description'))->data_value : null), ['class' => 'form-control m-input']) !!}
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
        $('#type').on('change', function (e) {
            e.preventDefault();

            let self = $(this);
            let menu = $('#menu');
            let category = $('#category');

            if (self.val() == '{{ \App\Models\Post::_TYPE_CONTACT }}') {
                menu.css('display', 'none');
                category.css('display', 'none');
            } else {
                if (self.val() == '{{ \App\Models\Post::_TYPE_HOME }}') {
                    menu.css('display', 'none');
                    category.css('display', 'none');
                } else {
                    menu.css('display', 'block');
                    category.css('display', 'block');
                }
            }
        });

        $(function () {
            CKEDITOR.replace('content', {
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

            $('.m-select2').select2();

            $('#type').trigger('change');

            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.posts.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            $('#page-box').change(function (e) {
                e.preventDefault();

                if ($(this).val() == 'vision-mission') {
                    $('#img-size').html('(570*517)');
                } else {
                    $('#img-size').html('(689*469)');
                }
            });

            $('#input-menu').on('change', function (e) {
                e.preventDefault();

                $.blockUI({message: ''});
                $.ajax({
                    url: route('ajax.posts.get-posts-by-menu'),
                    type: 'GET',
                    data: {
                        menu_id: $(this).val(),
                        menu_route_name: 'front.about-us',
                        except_id: '{{ !empty($id) ? $id : null }}'
                    },
                    success: function (response) {
                        if (response.code == 204) {
                            swal("", response.msg, "error");
                        } else if (response.code == 200) {
                            if (Object.keys(response.data).length > 0) {
                                $('#form-page').css('display', 'block');
                            } else {
                                $('#form-page').css('display', 'none');
                            }
                        }
                        $.unblockUI();
                    },
                    error: function (error) {
                        $.unblockUI();
                    }
                });
            });

            $('#input-menu').trigger('change');
            $('#page-box').trigger('change');

            // $('#content').summernote({
            //     height: 250,
            //     callbacks: {
            //         onImageUpload: function(files) {
            //             sendFile(files[0], this);
            //         }
            //     },
            //     popover: {
            //         image: [
            //             ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
            //             ['float', ['floatLeft', 'floatRight', 'floatNone']],
            //             ['remove', ['removeMedia']]
            //         ],
            //         link: [
            //             ['link', ['linkDialogShow', 'unlink']]
            //         ],
            //         table: [
            //             ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
            //             ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
            //         ],
            //         air: [
            //             ['color', ['color']],
            //             ['font', ['bold', 'underline', 'clear']],
            //             ['fontname', ''],
            //             ['para', ['ul', 'paragraph']],
            //             ['table', ['table']],
            //             ['insert', ['link', 'picture']]
            //         ],
            //     },
            // });

            {{--function sendFile(file, el) {--}}
            {{--var data = new FormData();--}}
            {{--data.append("_token", "{{ csrf_token() }}");--}}
            {{--data.append("file", file);--}}
            {{--$.ajax({--}}
            {{--data: data,--}}
            {{--type: "POST",--}}
            {{--url: route("admin.ajax.posts.upload-file"),--}}
            {{--cache: false,--}}
            {{--contentType: false,--}}
            {{--processData: false,--}}
            {{--success: function(response) {--}}
            {{--$(el).summernote('editor.insertImage', response.data);--}}
            {{--}--}}
            {{--});--}}
            {{--}--}}
        });
    </script>
@endsection
