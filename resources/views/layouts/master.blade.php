@include('layouts.header')
    @if(auth()->check())
        @include('layouts.bar')
    @endif
@yield('content')
@include('layouts.footer')
