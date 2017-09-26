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
    <link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style-responsive.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('style')
</head>
<body>
    <section id="container" >
          <!-- **********************************************************************************************************************************************************
          TOP BAR CONTENT & NOTIFICATIONS
          *********************************************************************************************************************************************************** -->
          <!--header start-->
          <header class="header-bg navbar-fixed-top navbar">
                  <div class="sidebar-toggle-box">
                      <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                  </div>
                <!--logo start-->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    <img src="{{ url('images/Genquiz.png') }}" alt="Genquiz" width="50%" style="margin-top:-10px;">
                </a>
                <!--logo end-->
                <!-- <div class="nav notify-row" id="top_menu">
                    notification start
                    <ul class="nav top-menu">
                        inbox dropdown start
                        <li id="header_inbox_bar" class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-theme">5</span>
                            </a>
                            <ul class="dropdown-menu extended inbox">
                                <div class="notify-arrow notify-arrow-green"></div>
                                <li>
                                    <p class="green">You have 5 new messages</p>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Zac Snider</span>
                                        <span class="time">Just now</span>
                                        </span>
                                        <span class="message">
                                            Hi mate, how is everything?
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="photo"><img alt="avatar" src="assets/img/ui-divya.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Divya Manian</span>
                                        <span class="time">40 mins.</span>
                                        </span>
                                        <span class="message">
                                         Hi, I need your help with this.
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="photo"><img alt="avatar" src="assets/img/ui-danro.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Dan Rogers</span>
                                        <span class="time">2 hrs.</span>
                                        </span>
                                        <span class="message">
                                            Love your new Dashboard.
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="photo"><img alt="avatar" src="assets/img/ui-sherman.jpg"></span>
                                        <span class="subject">
                                        <span class="from">Dj Sherman</span>
                                        <span class="time">4 hrs.</span>
                                        </span>
                                        <span class="message">
                                            Please, answer asap.
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">See all messages</a>
                                </li>
                            </ul>
                        </li>
                        inbox dropdown end
                    </ul>
                    notification end
                </div> -->
                <div class="top-menu">
                    <ul class="nav pull-right top-menu">
                        @if(Auth::check())
                            <li>
                                <a class="logout" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="logout" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </header>
          <!--header end-->
          <?php $show_sidebar = Auth::check() ? true : false;?>
            @if($show_sidebar)
                @include('partials.sidebar')
            @else
                <div class="container-fluid">
                    <div class="darkblue-panel" style="margin-top: 65px ;color: White;text-align: center;">
                        <div class="darkblue-header">
                            <h1>QuizGen - A Quiz Platform</h1>
                            <h2>Create &nbsp * &nbsp Play &nbsp * &nbsp Share  </h2>
                        </div>
                    </div>
                    <hr>
                </div>
            @endif
              <section @if(Auth::check()) id="main-content" @endif>
                <div class="row ml mr">
                    <h1>Quizzes : <hr></h1>
                        @yield('content')
                </div><!--/ row -->
              </section><! --/wrapper -->
        <!-- /MAIN CONTENT -->
    <!-- Scripts -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ URL::asset('js/jquery.dcjqaccordion.2.7.js') }}" ></script>
    <script src="{{ URL::asset('js/common-scripts.js') }}" ></script>
    @yield('scripts')
</body>
</html>
