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

  <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body>
	<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-light">
      <div class="container">
        <a class="navbar-brand" href="#">ITTEFAQ <small>Goods Transport</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <div class="border-right pr-1 strong">{{session('id')}} !</div>
            </li>
            <li class="nav-item">
              <div class="text-muted ml-1"><a href="{{route('signout')}}">Signout</a></div>
            </li>
          </ul>
        </div> 
      </div> 
    </nav>
  </header>
  
  @yield('page-title-section')
  @yield('page-data-section')
  @yield('modal-section')
  @yield('script')

</body>
</html>