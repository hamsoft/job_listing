<nav class="row navbar navbar-expand-lg navbar-dark bg-dark">

    <a class="navbar-brand" href="{{ route('home') }}">JobListing</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item @if(Route::is('home'))active @endif">
                <a class="nav-link" href="{{route('home')}}">@lang('List')<span class="sr-only">(current)</span></a>
            </li>

            @auth
                <li class="nav-item @if(Route::is('manage.company'))active @endif">
                    <a class="nav-link" href="{{route('manage.company')}}">Company</a>
                </li>
                <li class="nav-item @if(Route::is('manage.job-positions') ||
                Route::is('manage.job-position'))active @endif">
                    <a class="nav-link" href="{{route('manage.job-positions')}}">Job Positions</a>
                </li>
                <li class="nav-item @if(Route::is('manage.job-position.new'))active @endif">
                    <a class="nav-link" href="{{route('manage.job-position.new')}}">New Position</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">@lang('Logout')</a>
                </li>
            @else
                <li class="nav-item @if(Route::is('login'))active @endif">
                    <a class="nav-link" href="{{ route('login') }}">@lang('Login')</a>
                </li>
                <li class="nav-item @if(Route::is('register'))active @endif">
                    <a class="nav-link" href="{{ route('register') }}">@lang('Sign Up')</a>
                </li>
            @endauth

        </ul>
    </div>
</nav>