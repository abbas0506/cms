@extends ('admin-base')
@section('nav')
<section id='nav-section'>
   <div class="container mt-4">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('admin-home')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('forwarders.index')}}">Forwarders</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            <div class="col-md-6 border rounded shadow p-4 mt-4">
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
                    <span class="border-bottom border-success ml-2"><h4>Edit Forwarder</h4></span>
                </div>
                <div class='row no-gutters justify-content-center'>
                    <div class='col-sm-10'>
                        <form method="post" action="{{ route('forwarders.update', $forwarder->id) }}" autocomplete="off">
                            @csrf
                            @method('PATCH')
                            <div class="row form-group mt-4">    
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-user"></i></div>
                                <div class="col-sm-10"><input type="text" class="form-control" name="name" placeholder="Name" autocomplete="off" value="{{ $forwarder->name}}" required></div>
                            </div>
                        
                            <div class="row form-group">
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-phone"></i></div>
                                <div class="col-sm-10"><input type="text" class="form-control" name="phone" autocomplete='off' pattern='0[0-9]{10}' placeholder="First digit must be zero" value="{{ $forwarder->phone}}" required></div>
                            </div>
                            <div class="row form-group hidden" id='phone_sub'>
                              <div class="col micro teal text-right" id='phone_sub_text'>0 / 11</div>
                            </div>

                            <div class="row form-group">
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-at"></i></div>
                                <div class="col-sm-10"><input type="email" class="form-control" name="email" placeholder="Email" value="{{ $forwarder->email}}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-2 my-auto teal text-center"><i class="fa fa-home"></i></div>
                                <div class="col-sm-10"><input type="text" class="form-control" name="address" placeholder="Address" value="{{ $forwarder->address}}"></div>
                            </div>
                                    
                            <div class="row ">
                                <div class="col text-right">
                                    <a href="{{route('forwarders.index')}}" class="btn btn-info">Cancel</a>    
                                    <button type="submit" class="btn btn-success">Submit</button>
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
            if(txt.length==size) $('#phone_sub').hide();
            else{
              $('#phone_sub_text').html(txt.length+" / "+size);
              $('#phone_sub').show();

            }
            if(txt.length>size) $('#phone_sub').css('color','red');
            else $('#phone_sub').css('color','teal');
            
         });
    
  });

</script>
@endsection