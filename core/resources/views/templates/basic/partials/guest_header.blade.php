@extends($activeTemplate . 'layouts.header')

@section('menu')
    <div class="header-action">

        @auth
            <a href="{{ route('user.home') }}" class="btn--base">
                <i class="las la-tachometer-alt"></i> @lang('Dashboard')
            </a>

            <a href="{{ route('user.logout') }}" class="bg-white rounded">
                <i class="la la-sign-out"></i> @lang('Logout')
            </a>
        @else
            <a href="{{ route('user.login') }}" class="btn--base">
                <i class="las la-user-circle"></i> @lang('Login')
            </a>
        @endauth
    </div>
@endsection
