<script type="text/javascript">
    function widnowScreenWidth() {
        if ($(window).width() <= 1023) {
            $('.banner_inside').css('background-image', 'url('+ $('#mobile_banner').val() +')');
        } else {
            $('.banner_inside').css('background-image', 'url('+ $('#web_banner').val() +')');
        }
    }

    $(function () {
        $(window).resize(function(){
            widnowScreenWidth();
        });

        $(window).trigger('resize');
    });
</script>
