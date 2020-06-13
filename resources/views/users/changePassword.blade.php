<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS</title>
  <link href="{{ asset('css/app.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/mycss.css')}}" rel="stylesheet" type="text/css" />

  <script src="{{ asset('js/app.js')}}" type="text/js"></script>
  <script src="{{ asset('js/myjs.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/sweetAlert2@9.js')}}" type="text/javascript"></script>
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


  <style type="text/css">
      body{

        background-color: teal  ;
      }
      
  </style>

</head>
<body>

<div class="container p-5 mt-5 w-50">
<div class="p-2 text-center txt-lb light-brown">Change Password</div>
   
    @if ($errors->any())
        
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
        <br />
    @endif
    @if(session('response'))
      <div class="row no-gutters">
        <div class="col-sm-11 offset-sm-1">
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
             
            <form method="post" action="{{route('updatePassword')}}">
            @csrf
            
              <div class="row no-gutters form-group">
                  <div class="col-sm-1 my-auto text-light"><i class="fa fa-lock strong"></i></div>
                  <div class="col-sm-11">
                      <input type="password" class="form-control" name="currentPassword" placeholder="Old password" required>
                  </div>

              </div>
              
              <div class="row no-gutters form-group">
                  <div class="col-sm-1 my-auto text-light"><i class="fa fa-lock strong"></i></div>
                  <div class="col-sm-11">
                      <input type="password" class="form-control" name="newPassword" placeholder="New password" required>
                  </div>

              </div>
              <div class="row no-gutters form-group">
                  <div class="col-sm-1 my-auto text-light"><i class="fa fa-lock strong"></i></div>
                  <div class="col-sm-11">
                      <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm new password" required>
                  </div>


              </div>
             
              <div class="row no-gutters form-group">
                  
                  <div class="col text-right">
                    <a href="{{route('dashboard')}}" class="btn btn-outline-info">Cancel</a>
                    <button type="submit" class="btn btn-outline-success">Submit</button>
                  </div>
                  
              </div>

            
            </form>
    

    @endif
    
</div>       
</div>
  
</body>
</html>


