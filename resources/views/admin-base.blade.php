<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IGT</title>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <link href="{{ asset('css/app.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/mycss.css')}}" rel="stylesheet" type="text/css" />


  <script src="{{ asset('js/app.js')}}" type="text/js"></script>
  <script src="{{ asset('js/myjs.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/sweetAlert2@9.js')}}" type="text/javascript"></script>
  
  
</head>
<body>
	
  <div>
  <!------------------------------------------------------------- 
                                  navbar 
  -------------------------------------------------------------->
  <nav class="navbar navbar-expand-lg navbar-light">
    
      <img src="{{asset('uploads')}}/logo_transparent.png" style='width:50px;  height: 50px;' class="rounded-circle p-0 m-0">

    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    
    <div class="collapse navbar-collapse pl-4" id="navbarText">
      <ul class="navbar-nav mr-auto">
        
        <li class="nav-item">
          <a class="nav-link" href="{{route('users.index')}}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('consigners.index')}}">Consigners</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('consignees.index')}}">Consignees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('forwarders.index')}}">Forwarders</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{route('logs.index')}}">User Log</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('changePassword')}}">Change Password</a>
        </li>
      </ul>
      <span class="navbar-text">
        <span class="txt-s text-light">Welcome, {{session('id')}} !</span>
        <a href="{{route('signout')}}"><i class="fa fa-sign-out-alt pl-2 light-brown"></i></a>
      </span>
    </div>
  </nav>

  <!------------------------------------------------------------- 
                                  title bar 
  -------------------------------------------------------------->
  
  <div class="row no-gutters border-bottom p-2">
    <div class="col-sm-4 my-auto pl-2 txt-lb">
       @yield('page-title') 
      <i class="fas fa-caret-right pl-2"></i>
    </div>
    <div class="col-sm-6 my-auto"> @yield('searchbar') </div>
    <div class="col-sm-2 my-auto"> @yield('toolbar')   </div> 
  </div>
	
  
</div>
  <!------------------------------------------------------------- 
                                  page content 
  -------------------------------------------------------------->
  <div class="container w-75 content">
		
		  @yield('page')
		
	</div>

<!----------------------------------------------------------------------------
                                Create Consigner modal
------------------------------------------------------------------------------>

  <!-- Insert class Modal -->
  <div class="modal fade" id="changePasswordModal" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- modal body -->
        <div class="modal-body">
          
        </div>
      </div>
    </div> 
  </div>

  @yield('script')
  
</body>
</html>