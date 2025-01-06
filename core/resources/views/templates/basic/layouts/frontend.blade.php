@extends($activeTemplate . 'layouts.app')
@section('panel')
    <!-- @if (!request()->routeIs('home'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif -->

    @yield('content')
@endsection
