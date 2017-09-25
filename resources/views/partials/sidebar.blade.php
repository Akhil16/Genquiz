<!-- **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
        
            <p class="centered"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered">{{ Auth::user()->username}} </h5>
              
            <li class="mt">
                <a  href="{{ url('/profile') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sub-menu">
                <a  href="{{ url('profile/add-quiz') }}" >
                    <i class="fa fa-desktop"></i>
                    <span>Add Quiz</span>
                </a>
            </li>

            <li class="sub-menu">
                <a  href="{{ url('profile/quizzes') }}" >
                    <i class="fa fa-desktop"></i>
                    <span>Your Quizzes</span>
                </a>
            </li>

            <li class="sub-menu">
                <a  href="{{ url('profile/played-quiz') }}" >
                    <i class="fa fa-desktop"></i>
                    <span>Played Quiz</span>
                </a>
            </li>

            
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
