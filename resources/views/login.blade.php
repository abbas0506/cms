<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS</title>
  <link href="{{ asset('css/app.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/mycss.css')}}" rel="stylesheet" type="text/css" />

  <script src="{{ asset('js/app.js')}}" type="text/js"></script>
  <script src="{{ asset('js/myjs.js')}}" type="text/javascript"></script>
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

  <style type="text/css">
      body{

        background-color: #D0ECE7;
      }
      .container{
        border:none;
        border-radius: 5px;
        
        box-shadow: 20px 20px 20px #73C6B6;;
        padding-left: 40px;
        padding-right: 40px;
        padding-bottom: 10px;
        width:40%;
        margin-top: 10%;
        background-color: teal;
      }
  </style>

</head>
<body>

<div class="container">
    
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
    <div class="row no-gutters">
            <div class="col my-auto text-center">
                <img src="{{asset('uploads')}}/logo_transparent.png" style='width:150px;  height: 150px;' class="rounded-circle p-0 m-0">
            </div>
        </div>
        
        <form method="post" action="{{ route('auth') }}" autocomplete="off">
            @csrf

            <div class="row no-gutters form-group">    
                <div class="col-sm-1 my-auto text-light text-center"><i class="fa fa-user strong"></i></div>
                <div class="col-sm-11">
                    
                    <input type="text" class="form-control" name="id" placeholder="Enter user name" autocomplete="off" value='' required>
                </div>
                
            </div>
          
            <div class="row no-gutters form-group">
                <div class="col-sm-1 my-auto text-light text-center"><i class="fa fa-lock strong"></i></div>
                <div class="col-sm-11">
                    <input type="password" class="form-control" name="password" placeholder="Enter password" autocomplete="off" required>
                </div>

            </div>
                       
            <div class="row no-gutters">
                <div class="col text-right"><button type="submit" class="btn btn-success">Login</button></div>
                
            </div>
            
        </form>
                
</div>

</body>
<script type="text/javascript">
    $(document).ready(function(){
      //$("[name='id']").val('');
      //$("[name='password']").val('');

      $('form')[0].reset();
    });
  </script>
</html>


