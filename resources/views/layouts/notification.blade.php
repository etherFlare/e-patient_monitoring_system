 <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/icon002.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->email }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-custum">
              <li class="user-header">
                <img src="{{ asset('img/icon002.jpg') }}" class="img-circle" alt="User Image">
                <p>
                  
                <!--   <small>Member since the begining</small> -->
                </p>
              </li>
              <li class="user-footer">
              <!--   <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out </a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                 <!--  <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                </div>
              </li>
            </ul>
          </li>
          
          <li>
            
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          
        </ul>
      </div>