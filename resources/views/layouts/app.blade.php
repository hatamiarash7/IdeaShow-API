<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ایده شو</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mine.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/npm.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand my_font" href="http://arash-hatami.ir">ایده شو</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav my_font">
                <li>
                    <a href="{{ url('/') }}">خانه</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li>
                        <a class="my_font" href="{{ url('/login') }}">ورود</a>
                    </li>
                    <li>
                        <a class="my_font" href="{{ url('/register') }}">ثبت نام</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle my_font" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @if (Auth::user()->can_post())
                                <li>
                                    <a class="my_font" href="{{ url('/new-idea') }}">ایده جدید</a>
                                </li>
                                <li>
                                    <a class="my_font" href="{{ url('/user/'.Auth::id().'/ideas') }}">ایده های من</a>
                                </li>
                            @endif
                            <li>
                                <a class="my_font" href="{{ url('/user/'.Auth::id()) }}">پروفایل</a>
                            </li>
                            <li>
                                <a class="my_font" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    @if (Session::has('message'))
        <div class="flash alert-info">
            <p class="panel-body">
                {{ Session::get('message') }}
            </p>
        </div>
    @endif
    @if ($errors->any())
        <div class='flash alert-danger'>
            <ul class="panel-body">
                @foreach ( $errors->all() as $error )
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="my_font">@yield('title')</h2>
                    @yield('title-meta')
                </div>
                <div class="panel-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="flex-center">
            <h6 class="">Coded With <span class="fa fa-heart pulse2"></span> By Arash Hatami</h6>
        </div>
    </div>
</div>
</body>
</html>
