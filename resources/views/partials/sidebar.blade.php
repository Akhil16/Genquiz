<!-- **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
        
            <p class="centered"><a href="{{ url('/profile') }}"><img src="{{ URL::asset('images/user.png') }}"  class="img-circle" width="60"></a></p>
            <h5 class="centered">{{ Auth::check() ? Auth::user()->username : "User" }} </h5>
            
            @if(Auth::check())
                <li class="mt">
                    <a @if(url()->current() === url('/profile')) class="active" @endif href="{{ url('/profile') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Profile</span>
                    </a>
                </li>
            @else
                <li class="mt">
                    <a @if(url()->current() === url('/')) class="active" @endif href="{{ url('/') }}">
                        <i class="fa fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
            @endif

            <li class="sub-menu">
                <a @if(url()->current() === url('profile/add-quiz')) class="active" @endif href="{{ url('profile/add-quiz') }}" >
                    <i class="fa fa-plus"></i>
                    <span>Add Quiz</span>
                </a>
            </li>

            <li class="sub-menu">
                <a @if(url()->current() === url('profile/quizzes')) class="active" @endif href="{{ url('profile/quizzes') }}" >
                    <i class="fa fa-question"></i>
                    <span>Your Quizzes</span>
                </a>
            </li>

            <li class="sub-menu">
                <a @if(url()->current() === url('profile/played-quiz')) class="active" @endif href="{{ url('profile/played-quiz') }}" >
                    <i class="fa fa-futbol-o"></i>
                    <span>Played Quiz</span>
                </a>
            </li>

            @if(Auth::check() && Auth::user()->user_type == 2)
                <li class="sub-menu">
                    <a @if(url()->current() === url('profile/add-category')) class="active" @endif href="{{ url('profile/add-category') }}" >
                        <i class="fa fa-th-list"></i>
                        <span>Add Category</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a @if(url()->current() === url('profile/show-categories')) class="active" @endif href="{{ url('profile/show-categories') }}" >
                        <i class="fa fa-bolt"></i>
                        <span>Show Categories</span>
                    </a>
                </li>
            @endif
            
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
