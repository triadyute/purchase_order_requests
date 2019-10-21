
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Purchase Order Portal</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:600&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <!--Font Aweome-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/sticky-footer-navbar.css')}}" rel="stylesheet">
    <!--Data tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/datatables.min.css"/>
    <link rel="stylesheet" href="{{asset('/css/dataTables.min.css')}}">
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css">
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container">
          <a class="navbar-brand" href="/home"><img src="{{asset('img/logo.png')}}" height="45" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PO Requests</a>
                <div class="dropdown-menu" aria-labelledby="dropdown07">
                  <a class="dropdown-item" href="/purchase-order-request/create">Submit PO Request</a>
                  <a class="dropdown-item" href="/purchase-order-request">View PO Requests</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"  id="dropdown08" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Users</a>
                <div class="dropdown-menu" aria-labelledby="dropdown08">
                  <a class="dropdown-item" href="{{route('create.user')}}">Add User</a>
                  <a class="dropdown-item" href="#">Manage Users</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
              </li>
            </ul>

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
              <img src="{{asset('/img/avatar.png')}}" alt="" class="rounded-circle float-left" height="35" width="35">
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
                          <a href="#" class="dropdown-item">
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
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
      @yield('content')
    </main>

    <footer class="footer" style="background:#eee;">
      <div class="container">
        <span>&copy; 2019 Fabian Henry. All rights reserved.</span><span class="float-right">Purchase Order Portal v1.0.1</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.58/pdfmake.js"></script>
    <script src="{{ asset('js/jszip/dist/jszip.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.58/vfs_fonts.js"></script>
    <script src="{{ asset('/js/popper.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.58/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
    <script>
            $(function () {
                $(".datepicker").datepicker({ 
            format: "yyyy-mm-dd", 
            });
        });
    </script>
    @yield('scripts')
  </body>
</html>
