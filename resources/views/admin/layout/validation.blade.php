@if($errors->any())
    <div class="m-alert m-alert--icon alert alert-danger m--margin-left-30 m--margin-right-30" role="alert">
        <div class="m-alert__icon">
            <i class="la la-warning"></i>
        </div>
        <div class="m-alert__text">
            <ul>
                @if (!empty($custom_msg_validation))
                    @foreach($errors->messages() as $k => $e)
                        @php($index = explode('.', $k))
                        @php($n = (isset($index[1]) && !empty($index[1])) ? $index[1] + 1 : 0)
                        @php($n = (!empty($n) && $n != 0) ? "#$n" : '')
                        @foreach($e as $v)
                            <li>{{ $n }} {{ $v }}</li>
                        @endforeach
                    @endforeach
                @else
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="m-alert__close">
            <button type="button" class="close" data-close="alert" aria-label="Hide"></button>
        </div>
    </div>
@endif
