@extends("admin.layout.form")

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.users.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('form_input')
    {!! Form::open(['method' => !empty($id) ? 'PUT' : 'POST', 'route' => !empty($id) ? ['admin.users.update', 'id' => $id] : ['admin.users.store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        @include('admin.layout.validation')
        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-name') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($page_setting['attr'].'-name', old($page_setting['attr'].'-name', !empty($id) ? $data->name : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-email') }} <span class="text-danger">(*)</span></label>
            {!! Form::text($page_setting['attr'].'-email', old($page_setting['attr'].'-email', !empty($id) ? $data->email : ''), ['class' => 'form-control m-input', !empty($id) ? 'disabled' : '']) !!}
        </div>

        <div class="form-group m-form__group">
            <label for="">{{ __('validation.attributes.'.$page_setting['attr'].'-phone_number') }} <span class="text-danger"></span></label>
            {!! Form::text($page_setting['attr'].'-phone_number', old($page_setting['attr'].'-phone_number', !empty($id) ? $data->phone_number : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$page_setting['attr'].'-position') }} <span class="text-danger">(*)</span></label>
            {!! Form::select($page_setting['attr'].'-position', $position_arr, old($page_setting['attr'].'-position', !empty($id) ? $data->position_id : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$page_setting['attr'].'-role') }} <span class="text-danger">(*)</span></label>
            {!! Form::select($page_setting['attr'].'-role', $role_arr, old($page_setting['attr'].'-role', !empty($id) ? $owner_role_id : ''), ['class' => 'form-control m-input']) !!}
        </div>

        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.status') }} <span class="text-danger">(*)</span></label>
            {!! Form::select('status', __('datametas.select-box.status'), old('status', !empty($id) ? $data->status : \App\Models\Constant::STATUS_ACTIVE), ['class' => 'form-control m-input']) !!}
        </div>

        <hr />
        <div class="form-group m-form__group">
            <label class="col-form-label">{{ __('validation.attributes.'.$page_setting['attr'].'-department') }} - {{ __('validation.attributes.'.$page_setting['attr'].'-field') }}</label>
        </div>

        @foreach($field_arr as $k => $field_item)
            <div class="form-group m-form__group">
                <label class="col-form-label">{{ $field_item }}</label>
                <div class="pull-right">
                    @php($sall = old($page_setting['attr']."-department.$k.all", !empty($id) && isset($field_depts[$k]['all']) ? $field_depts[$k]['all'] : 0))
                    <input type="hidden" name="{{ $page_setting['attr']."-department[$k][all]" }}" id="as_{{ $k }}" value="{{ $sall }}" />
                    <input type="button" class="btn btn-sm btn-outline-success" value="Đã chọn toàn quyền" id="fs_{{ $k }}" style="@if ($sall != 1) display: none; @endif" />
                    <input type="button" class="btn btn-sm btn-warning" value="{{ __('custom.button.select-all') }}" onclick="return select_all('{!! $k !!}');" />
                    <input type="button" class="btn btn-sm btn-danger" value="{{ __('custom.button.deselect-all') }}" onclick="return deselect_all('{!! $k !!}');" />
                </div>
                {!! Form::select($page_setting['attr']."-department[$k][field][]", \App\Models\Department::getList(['field' => $k]), old($page_setting['attr']."-department.$k.field", !empty($id) && isset($field_depts[$k]['own_depts']) ? $field_depts[$k]['own_depts'] : null), ['class' => 'form-control m-input multiselect_custom', 'id' => 's_'.$k, 'multiple' => true]) !!}
            </div>
        @endforeach

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            {!! Form::submit(__('custom.button.save'), ['class' => 'btn btn-primary', 'onclick' => "$.blockUI({message: ''});",]) !!}
            <a class="btn btn-secondary" href="{{ !empty($id) ? route('admin.users.edit', ['id' => $id]) : route('admin.users.create') }}">{{ __('custom.button.reset') }}</a>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section("script")
    <script>
        function select_all(id) {
            $("#s_"+id+" > option").prop("selected","selected").change();
            $('#as_'+id).val(1);
            $('#fs_'+id).show();
        }
        function deselect_all(id) {
            $("#s_"+id).val(null).change();
            $('#as_'+id).val(0);
            $('#fs_'+id).hide();
        }
        $(function () {
            $(".multiselect_custom").select2({
                placeholder: '',
            });

            $(".multiselect_custom").on("select2:unselect", function (e) {
                var sid = $(this)[0].id;
                $('#a'+sid).val(0);
                $('#f'+sid).hide();
            });
        });
    </script>
@endsection




