@extends("admin.layout.table")

@section('css')
    <style>
        .sorting_custom_bg_color {
            background-color: #0034ff12;
        }
    </style>
@endsection

@section('link_url')
    <div class="m-portlet__head-text text-right">
        <a href="{{ route('admin.menus.index') }}" class="btn btn-accent">
            {{ __('custom.button.list') }}
        </a>
    </div>
@endsection

@section('list')
    <div class="m-section__content">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="row" id="m_sortable_portlets">
                <div class="col-md-6 offset-md-3">
                    @foreach($data as $i => $item)
                        <div class="m-portlet m-portlet--responsive-tablet-and-mobile m-portlet--sortable sorting_custom_bg_color">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon"><i class="flaticon-menu-button"></i></span>
                                        <h3 class="m-portlet__head-text m--font-brand">
                                            {{ optional($item->datameta('', ($type == 'post') ? 'title' : 'name'))->data_value }}
                                        </h3>
                                        <input type="hidden" name="title" value="{{ $item->id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                        <div class="m-demo__preview m-demo__preview--btn">
                            <a href="#" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--air" id="submit_sort_id">
                                <i class="fa flaticon-interface-5"></i>
                            </a>
                            <a href="javascript:window.location.reload()" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--air">
                                <i class="fa flaticon-cancel"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script src="{{ asset("assets/vendors/custom/jquery-ui/jquery-ui.bundle.js") }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#submit_sort_id').on('click', function (e) {
            e.preventDefault();

            var arrSort = [];

            $('input[name="title"]').map(function(){
                return arrSort.push(this.value);
            });

            $.blockUI({message:''});

            $.ajax({
                url: route('admin.ajax.menus.sorting'),
                type:'POST',
                data: {
                    id: arrSort,
                    sort: '{{ $sort }}',
                    type: '{{ $type }}'
                },
                success: function (response) {
                    if (response.code == 201) {
                        swal("", response.msg, "error");
                        $.unblockUI();
                    }

                    else if (response.code == 200) {
                        swal({
                            type: 'success',
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.reload();
                    }
                },
                error: function (error) {
                    $.unblockUI();
                }
            });
        });

        var PortletDraggable = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $("#m_sortable_portlets").sortable({
                        connectWith: ".m-portlet__head",
                        items: ".m-portlet",
                        opacity: 0.8,
                        handle : '.m-portlet__head',
                        coneHelperSize: true,
                        placeholder: 'm-portlet--sortable-placeholder',
                        forcePlaceholderSize: true,
                        tolerance: "pointer",
                        helper: "clone",
                        cancel: ".m-portlet--sortable-empty", // cancel dragging if portlet is in fullscreen mode
                        revert: 250, // animation in milliseconds
                        update: function(b, c) {
                            if (c.item.prev().hasClass("m-portlet--sortable-empty")) {
                                c.item.prev().before(c.item);
                            }
                        }
                    });
                }
            };
        }();

        $(function () {
            PortletDraggable.init();
        });
    </script>
@endsection
