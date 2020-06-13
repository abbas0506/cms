@extends ('admin-base')
@section('page-title','New User')
@section('searchbar')
   @parent
@endsection

@section('toolbar')
  
  
@endsection

@section('page')

<div class="container w-50 border-0 p-5 shadow-lg">
    
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
        <form method="post" action="{{ route('users.store') }}">
            @csrf
            
            <div class="row no-gutters form-group">    
                <div class="col-sm-1 my-auto teal"><i class="fa fa-user strong"></i></div>
                <div class="col-sm-11">
                    
                    <input type="text" class="form-control" name="id" placeholder="Enter user name" required>
                </div>
                
            </div>
          
            <div class="row no-gutters form-group">
                <div class="col-sm-1 my-auto teal"><i class="fa fa-lock strong"></i></div>
                <div class="col-sm-11">
                    <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                </div>

            </div>
            <div class="row no-gutters form-group">
                <div class="col-sm-1 my-auto teal"><i class="fa fa-lock strong"></i></div>
                <div class="col-sm-11">
                    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password" required>
                </div>


            </div>
           
            <div class="row no-gutters form-group">
                <div class="col text-right"><button type="submit" class="btn btn-success">Submit</button></div>
                
            </div>

            
        </form>
    
</div>

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
