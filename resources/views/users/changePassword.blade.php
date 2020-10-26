<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS</title>
  <link href="{{ asset('css/app.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/mycss.css')}}" rel="stylesheet" type="text/css" />

  <script src="{{ asset('js/app.js')}}" type="text/js"></script>
  <script src="{{ asset('js/myjs.js')}}" type="text/javascript"></script>
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="row no-gutters justify-content-center">

            <div class="col-md-5 border rounded shadow p-4" id='login-screen'>

            @if ($errors->any())
               <div class='row no-gutters'>
                  <div class="alert alert-danger no-gutters">
                     <ul>
                     @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                     @endforeach
                  </ul>
                  </div>
               </div> 
               
            @endif
            @if(session('response'))
               <div class="row no-gutters">
               <div class="col">
                  <div class="alert alert-danger text-center">{{session('response')}} </div>
                  <br />
               </div>

               </div>
               
            @endif
            @if(session('success'))
               <div class="row no-gutters">
                  <div class="col text-center">
                              <div class="alert alert-success text-center">{{session('success')}} <br> 
                              Please <a href="{{url('/')}}"> sign in </a> again </div>
                     <br />
                  </div>

               </div>
            @else
            <div class='row no-gutters form-group'>
                <span class="border-bottom border-success ml-2"><h3>Change Password</h3></span>
            </div>
            <div class='row no-gutters justify-content-center'>
                <div class='col-sm-10'>
                    <form method="post" action="{{ route('updatePassword') }}" autocomplete="off">
                        @csrf
                            <div class="row form-group mt-4">    
                            <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-lock strong"></i></div>
                            <div class="col-sm-10"><input type="text" class="form-control" name="currentPassword" placeholder="Old password" autocomplete="off" value='' required></div>
                            
                        </div>
                    
                        <div class="row form-group">
                            <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-lock strong"></i></div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="newPassword" placeholder="New Password" autocomplete="off" required>
                            </div>

                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-lock strong"></i></div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" autocomplete="off" required>
                            </div>

                        </div>
                                
                        <div class="row ">
                           <div class="col text-right">
                              <a href="{{route('dashboard')}}" class="btn btn-info">Cancel</a>    
                              <button type="submit" class="btn btn-success">Login</button>
                           </div>
                            
                        </div>
                        
                    </form>

                </div>

            </div>
            
            @endif
            
            </div>
        </div>
    </div>
</body>
</html>


