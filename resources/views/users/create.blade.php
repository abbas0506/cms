@extends ('admin-base')
@section('nav')
<section id='nav-section'>
   <div class="container mt-4">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('admin-home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Users</li>
               </ol>
            </nav>
        </div>
    </div>
</section>
@endsection

@section('data')

<section id='data-section'>
	<div class='container'>
		<div class="row justify-content-center">
            <div class="col-md-5 border rounded shadow p-4 mt-4">
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
                <div class='row no-gutters form-group'>
                    <span class="border-bottom border-success ml-2"><h3>New User</h3></span>
                </div>
                <div class='row no-gutters justify-content-center'>
                    <div class='col-sm-10'>
                        <form method="post" action="{{ route('users.store') }}" autocomplete="off">
                            @csrf
                            <div class="row form-group mt-4">    
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-user strong"></i></div>
                                <div class="col-sm-10"><input type="text" class="form-control" name="id" placeholder="User name" autocomplete="off" value='' required></div>
                            </div>
                        
                            <div class="row form-group">
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-lock strong"></i></div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-lock strong"></i></div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password" autocomplete="off" required>
                                </div>
                            </div>
                                    
                            <div class="row ">
                                <div class="col text-right">
                                    <a href="{{route('users.index')}}" class="btn btn-info">Cancel</a>    
                                    <button type="submit" class="btn btn-success">Login</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script type="text/javascript">
  
  $(document).ready(function(){
    
    $("[name='phone']").keyup(function(){     //guide phone format
            var size=11;
            var txt=$("[name='phone']").val();
            if(txt=='') $('#phone_sub').hide();
            else{
                              
               var spc='';
               for(i=0; i<size-txt.length; i++){
                  spc+=' -';
               }
               $('#phone_sub_text').html(txt+spc);
               $('#phone_sub').show();

            }
            
            if(txt.length==size) $('#phone_sub').hide();
            else if(txt.length>size) $('#phone_sub').css('color','red');
            else $('#phone_sub').css('color','grey');
            
         });
    $('form').submit(function(e){

        e.preventDefault();
        var password=$("[name='password']").val();
        var confirmPassword=$("[name='confirmPassword']").val();
        if(password==confirmPassword) {
            $('form')[0].submit();
        }else 
        {
            Swal.fire({
              icon: 'warning',
              text: "Password mismatched!",
              showConfirmButton: false,
              timer:2000
            });
        }
    });

  });

</script>
@endsection
