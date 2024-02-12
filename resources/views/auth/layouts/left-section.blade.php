<a href="javascript:void(0);" class="close ic_main">&#xe04b;</a>
<div class="login_banner" style="background-image:url({{ asset(isset($banner) && !empty($banner) ? $banner->media->web_path : "front-end/images/demo/bg_login.jpg") }});">
    <div class="connect_thaco">
        <h4>{{ __('custom.front-end.connect-thaco') }}</h4>
        <div class="list_social">
            <a href="javascript:void(0);">
                <span class="ic_thaco">&#xe007;</span>Facebook
            </a>
            <a href="javascript:void(0);">
                <span class="ic_thaco">&#xe008;</span>Linked In
            </a>
        </div>
    </div>
</div>
