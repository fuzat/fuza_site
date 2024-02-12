@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.board-directors.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    @php($prefix = \App\Models\BoardDirector::_ATTR . '-')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.board-directors.update', 'id' => $id] : ['admin.board-directors.store'], 'files' => true, 'class' => 'm-form m-form--fit m-form--label-align-right', ]) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.locale') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('locale', __('datametas.select-box.locale'), old('locale', !empty($id) ? $lang : \LaravelLocalization::getCurrentLocale()), ['class' => 'form-control m-input', 'id' => !empty($id) ? 'locale' : null]) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.' . $prefix . 'name') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($prefix . 'name', old($prefix . 'name', !empty($id) ? optional($data->datameta($lang, 'name'))->data_value : null), ['class' => 'form-control m-input']) !!}
        </div>

        @if(!empty($id))
            <div class="form-group m-form__group">
                <label>{{ __('validation.attributes.' . $prefix . 'avatar') }} <span class="text-danger">(*)</span></label>

                @if($lang != env('APP_LOCALE'))
                    {!! Form::file($prefix . 'avatar', ['class' => 'form-control m-input', 'disabled']) !!}
                @else
                    {!! Form::file($prefix . 'avatar', ['class' => 'form-control m-input']) !!}
                @endif

                @if($data->on_top == \App\Models\Constant::STATUS_ACTIVE)
                    <span class="m-form__help m--valign-top" id="size-avatar">(412*329)</span>
                @elseif($data->on_top == \App\Models\Constant::STATUS_INACTIVE)
                    <span class="m-form__help m--valign-top" id="size-avatar">(293*382)</span>
                @endif

                @if($data->media && $data->on_top == \App\Models\Constant::STATUS_INACTIVE)
                    <img src="{{ $data->media->thumbnail_path }}" id="media">
                @elseif($data->media_big && $data->on_top == \App\Models\Constant::STATUS_ACTIVE)
                    <img src="{{ $data->media_big->thumbnail_path }}" id="media">
                @endif
            </div>
        @else
            <div class="form-group m-form__group">
                <label>{{ __('validation.attributes.' . $prefix . 'avatar') }} <span class="text-danger">(*)</span></label>
                {!! Form::file($prefix . 'avatar', ['class' => 'form-control m-input']) !!}
                <span class="m-form__help m--valign-top" id="size-avatar">(293*382)</span>
            </div>
        @endif

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.' . $prefix . 'position') }} <span class="text-danger">(*)</span></label>
            @if(!empty($id))
                @if($lang != env('APP_LOCALE'))
                    {!! Form::select($prefix . 'position[]', $positions, old($prefix . 'position[]', $data->positions()->get(['id'])->pluck('id')), ['class' => 'form-control m-select2', 'multiple' => 'multiple', 'disabled']) !!}
                @else
                    {!! Form::select($prefix . 'position[]', $positions, old($prefix . 'position[]', $data->positions()->get(['id'])->pluck('id')), ['class' => 'form-control m-select2', 'multiple' => 'multiple']) !!}
                @endif
            @else
                {!! Form::select($prefix . 'position[]', $positions, old($prefix . 'position[]', null), ['class' => 'form-control m-select2', 'multiple' => 'multiple']) !!}
            @endif
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.on_top') }} <span class="text-danger">(*)</span></label>
            @if(!empty($id))
                @if($lang != env('APP_LOCALE'))
                    {!! Form::select('on_top', __('datametas.select-box.unhidden'), old('on_top', $data->on_top), ['class' => 'form-control m-input', 'disabled']) !!}
                @else
                    {!! Form::select('on_top', __('datametas.select-box.unhidden'), old('on_top', $data->on_top), ['class' => 'form-control m-input']) !!}
                @endif
            @else
                {!! Form::select('on_top', __('datametas.select-box.unhidden'), old('on_top', \App\Models\Constant::STATUS_INACTIVE), ['class' => 'form-control m-input']) !!}
            @endif
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.' . $prefix . 'description-1') }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($prefix . 'description-1', old($prefix . 'description-1', !empty($id) ? optional($data->datameta($lang, 'description-1'))->data_value : null), ['class' => 'form-control m-input', 'id' => $prefix . 'description-1']) !!}
        </div>

        <div class="form-group m-form__group" id="description-2">
            <label>{{ __('validation.attributes.' . $prefix . 'description-2') }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($prefix . 'description-2', old($prefix . 'description-2', !empty($id) ? optional($data->datameta($lang, 'description-2'))->data_value : null), ['class' => 'form-control m-input', 'id' => $prefix . 'description-2']) !!}
        </div>

        <div class="form-group m-form__group" id="hover-1">
            <label>{{ __('validation.attributes.' . $prefix . 'hover-1') }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($prefix . 'hover-1', old($prefix . 'hover-1', !empty($id) ? optional($data->datameta($lang, 'hover-1'))->data_value : null), ['class' => 'form-control m-input', 'id' => $prefix . 'hover-1']) !!}
        </div>

        <div class="form-group m-form__group" id="hover-2">
            <label>{{ __('validation.attributes.' . $prefix . 'hover-2') }} <span class="text-danger">(*)</span></label>
            {!! Form::textarea($prefix . 'hover-2', old($prefix . 'hover-2', !empty($id) ? optional($data->datameta($lang, 'hover-2'))->data_value : null), ['class' => 'form-control m-input', 'id' => $prefix . 'hover-2']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_ACTIVE), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label>{{ __('validation.attributes.sorting') }} <span class="text-danger">(*)</span></label>
            {!! Form::text('sorting', old('status', !empty($id) ? $data->sorting : 0), ['class' => 'form-control m-input number']) !!}
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
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    <script type="text/javascript">
        function showDescAndHover(val) {
            if(val == '{{ \App\Models\Constant::STATUS_ACTIVE }}') {
                $('#size-avatar').html('(412*329)');
                $('#description-2').css('display', 'block');
                $('#hover-2').css('display', 'block');
                $('#media').attr('src', '{{ !empty($data->media_big) ? asset($data->media_big->thumbnail_path) : null }}');
            } else {
                $('#size-avatar').html('(293*382)');
                $('#description-2').css('display', 'none');
                $('#hover-2').css('display', 'none');
                $('#media').attr('src', '{{ !empty($data->media) ? asset($data->media->thumbnail_path) : null }}');
            }
        }

        $(function () {
            CKEDITOR.replace('{{ $prefix . 'description-1' }}', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('{{ $prefix . 'description-2' }}', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('{{ $prefix . 'hover-1' }}', {
                removeButtons: 'Styles',
                filebrowserBrowseUrl: '/elfinder/ckeditor',
                keystrokes: [
                    [ 13 /*Enter*/, 'doNothing'],
                    [ CKEDITOR.SHIFT + 13 /*Shift-Enter*/, 'doNothing'],
                ],
            });
            CKEDITOR.replace('{{ $prefix . 'hover-2' }}', {
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

            $('.m-select2').select2({});
            $('input.number').number(true, 0);

            $('#locale').on('change', function () {
                $.blockUI({message: ''});
                window.location.replace(route('admin.board-directors.edit', {id: '{!! !empty($id) ? $id : 0 !!}', lang: $(this).val()}), true);
            });

            var on_top = $('select[name=on_top]');

            on_top.on('change', function () {
                showDescAndHover(on_top.val());
            });

            showDescAndHover(on_top.val());
        });
    </script>
@endsection
