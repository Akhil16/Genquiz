<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <?php
        $title = isset($title) ? $title : "Genquiz - a Quiz Platform";
        $description = isset($description) ? $description : "A platform to solve quizzes and share your created quizzes among your friend circle";
        $keywords = isset($keywords) ? $keywords : "genquiz, quiz, puzzles";
        $author = isset($author) ? $author : "Genquiz";
        $url = isset($url) ? $url : "http//genquiz.tk";
        $site_name = isset($site_name) ? $site_name : "genquiz.tk";
        $image_url = isset($image_url) ? $image_url : url('/images/Genquiz.png');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="{{ $author }}">
    <link rel="canonical" href="{{ $url }}"/>
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:site_name" content="{{ $site_name }}" />
    <meta property="og:image" content="{{ $image_url }}"/>
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $url }}"/>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $site_name }}">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:creator" content="@genquiz">
    <meta name="twitter:image" content="{{ $image_url }}">
    <meta name="twitter:url" content="{{ $url }}">
    <link rel="shortcut icon" href="{{ url('/images/favicon.ico') }}" 
    alt="{{$description }} ,{{ $keywords }}">
    <meta name="google-site-verification" content="" />
    <meta name="theme-color" content="#000000">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-custom">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!-- {{ config('app.name', 'Laravel') }} -->
                        <img src="{{ url('images/Genquiz.png') }}" alt="Genquiz" width="50%" style="margin-top:-10px;">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/profile') }}">Profile</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @yield('scripts')
</body>
</html>
