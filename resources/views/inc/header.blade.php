<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="/home"><img src="{{asset('img/logo.png')}}" height="45" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          @auth
            <ul class="navbar-nav mr-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PO Requests</a>
                <div class="dropdown-menu" aria-labelledby="dropdown07">
                  <a class="dropdown-item" href="{{route('purchase-order-request.create')}}"> <i class="fa fa-file"></i> Submit PO Request</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{route('purchase-order-request.index')}}"> <i class="fa fa-folder-open"></i> View PO Requests</a>
                </div>
              </li>
              @can('manage-all-users', User::class)
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"  id="dropdown08" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Users</a>
                <div class="dropdown-menu" aria-labelledby="dropdown08">
                  <a class="dropdown-item" href="{{route('create.user')}}"> <i class="fa fa-user-plus"></i> Add User</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{route('user.index')}}"> <i class="fa fa-users"></i> Manage Users</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{route('department.index')}}"> <i class="fa fa-users"></i> Departments</a>
                </div>
              </li>
              @endcan
            </ul>
          @endauth

          <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
            <li class="nav-item">
              @if (isset(Auth::user()->profile_photo))
              @if( Auth::user()->profile_photo == 'avatar.png')
                <img src="{{asset('/img/avatar.png')}}" class="rounded-circle float-left round-avatar" height="27" width="27" alt="profile photo">
              @else
                <img src="{{asset('/storage/profile_photos/'.Auth::user()->profile_photo)}}" class="rounded-circle float-left round-avatar" height="27" width="27" alt="profile photo">
              @endif
              @endif
            </li>
            <li class="nav-item dropdown float-right">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> <i class="fa fa-bell fa-lg"></i> @if(count(Auth::user()->unreadNotifications) != 0 )<span class="count-notification">{{count(Auth::user()->unreadNotifications)}} @endif</span></a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @foreach (Auth::user()->unreadNotifications as $notification)
                      <a href="{{$notification->data['url']}}" class="dropdown-item" id="navbarDropdown">{{$notification->data['message']}}</a>           
                    @endforeach
                  </div>  
                 
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      @if(count(Auth::user()->unreadNotifications) == 0 )
                        <a class="dropdown-item" id="navbarDropdown">No notifications</a>   
                      @endif     
                    </div>  
            </li>
            <li class="nav-item dropdown float-right">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                          <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{route('user.show', Auth::user())}}" class="dropdown-item">
                            <i class="fa fa-user"></i> My profile
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
    <!--<div class="bgimage"></div>-->
  </header>