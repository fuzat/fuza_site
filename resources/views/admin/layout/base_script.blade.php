<script src="{{ asset("assets/vendors/base/vendors.bundle.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/demo/demo3/base/scripts.bundle.js") }}" type="text/javascript"></script>
<script type="text/javascript">
    setTimeout(function () {
        $('#alert-msg').remove();
    }, 5000);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
</script>
