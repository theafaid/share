@include('layouts.partials.header')
<div id="app">
    @include('layouts.partials.nav')
    @yield('content')
</div>
@include('layouts.partials.footer')