@if(session()->has('success') || session()->has('fail'))
    <div id="alert-msg" class="m-section">
        <div class="m-section__content">
            <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert @if(session()->has('success')) alert-success @elseif(session()->has('fail')) alert-danger @endif
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
