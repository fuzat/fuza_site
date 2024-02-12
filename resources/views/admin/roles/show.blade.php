@extends("admin.layout.app")

@section('title', $page_setting['title'])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title w-100">
                                    <h3 class="m-portlet__head-text">
                                        {{ $page_setting['title'] }} <span class="text-info">{{ $role->display_name }}</span>
                                    </h3>
                                    <div class="m-portlet__head-text text-right">
                                        <a href="{{ route('admin.roles.index') }}" class="btn btn-default m-btn m-btn--custom m-btn--icon m-btn--air">
                                            {{ __('custom.button.list') }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-12">
                                    @if(session()->has('success') || session()->has('fail'))
                                        <div class="m-section">
                                            <div class="m-section__content">
                                                <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert
                                                    @if(session()->has('success')) alert-success @elseif(session()->has('fail')) alert-danger @endif
                                                        alert-dismissible fade show" role="alert">
                                                    <div class="m-alert__icon">
                                                        <i class="flaticon-exclamation-1"></i>
                                                    </div>
                                                    <div class="m-alert__text">
                                                        <strong>
                                                            @if(session()->has('success'))
                                                                {{ session()->get('success') }}
                                                            @elseif(session()->has('fail'))
                                                                {{ session()->get('fail') }}
                                                            @endif
                                                        </strong>
                                                    </div>
                                                    <div class="m-alert__close">
                                                        <button type="button" class="close" data-close="alert" aria-label="Hide"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @include('admin.layout.validation')

                            </div>
                            <div class="col-md-6 offset-md-3">
                                @if($data)
                                    <div class="m-portlet__head-text text-right">
                                        <button class="btn btn-sm btn-warning" id="select_all_id">{{ __('custom.button.select-all') }}</button>
                                        <button class="btn btn-sm btn-danger" id="deselect_all_id">{{ __('custom.button.deselect-all') }}</button>
                                    </div>
                                    <br>

                                    {!! Form::open(['method' => 'POST', 'route' => ['admin.roles.permissions.change', 'id' => $id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'open_form_id']) !!}
                                    <table class="table m-table m-table--head-separator-primary" id="permission_table_id">
                                        <tbody>
                                        @php($module = '')
                                        @foreach($data as $item)
                                            @php($check = $role->hasPermission($item->name) ? 1 : 0)
                                            @if ($module != $item->module)
                                                @php($module = $item->module)
                                                <tr class="bg-light">
                                                    <td class="text-center bg-secondary">
                                                        <input id="id_inputCB_{{ $item->module }}" class="class_{{ $item->module }}" type='checkbox' value="{{ $item->module }}" onclick="return changeCheckboxAll('{{ $item->module }}');" />
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold text-danger">{{ __('custom.permission.module.'.$item->module) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="">
                                                    <input id="inputCB_{{ $item->id }}" class="class_{{ $item->module }}" type='checkbox' name='chosed_permissions[]' value='{{ $item->id }}' {{ ($check == 1) ? 'checked="checked"' : '' }} onclick="return changeCheckbox('{{ $item->id }}', '{{ $item->module }}');" />
                                                </td>
                                                <td id="keyword_{{ $item->id }}" class="{{ $check == 1 ? 'font-weight-bold text-primary' : '' }} kw_class_{{ $item->module }} display_name_class">{{ $item->display_name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! Form::close() !!}
                                @endif
                            </div>

                            @if ($data)
                                <hr>
                                <div class="m-portlet__head-text text-right">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default m-btn m-btn--custom m-btn--icon m-btn--air">
                                        {{ __('custom.button.list') }}
                                    </a>
                                    <a href="{{ url()->current() }}" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--air">
                                        {{ __('custom.button.reset') }}
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" onclick=" $.blockUI({message:''}); return $('#open_form_id').submit();">
                                        {{ __('custom.button.update') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script type="text/javascript">

        function changeCheckboxAll(module_name) {
            var remember = document.getElementById('id_inputCB_'+module_name);
            var l = $('#permission_table_id').find(".class_"+module_name);
            if (remember.checked) {
                l.each(function(){
                    this.checked = true;
                });
                $('.kw_class_'+module_name).addClass('font-weight-bold text-primary');
            } else {
                l.each(function(){
                    this.checked = false;
                });
                $('.kw_class_'+module_name).removeClass('font-weight-bold text-primary');
            }
        }

        function changeCheckbox(per_id, module_name) {
            var remember = document.getElementById('inputCB_'+per_id);
            if (remember.checked) {
                $('#keyword_'+per_id).addClass('font-weight-bold text-primary');
            } else {
                document.getElementById('id_inputCB_'+module_name).checked = false;
                $('#keyword_'+per_id).removeClass('font-weight-bold text-primary');
            }
        }

        $(function () {
            $('#select_all_id').click(function () {
                var l = $('#permission_table_id').find("input[type=checkbox]");
                if (l.length > 0) {
                    l.each(function(){
                        this.checked = true;
                    });
                    $('.display_name_class').addClass('font-weight-bold text-primary');
                }
            });

            $('#deselect_all_id').click(function () {
                var l = $('#permission_table_id').find("input[type=checkbox]");
                if (l.length > 0) {
                    l.each(function(){
                        this.checked = false;
                    });
                    $('.display_name_class').removeClass('font-weight-bold text-primary');
                }
            });

        });

    </script>
@endsection
