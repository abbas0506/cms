@extends ('user-base')

@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('containers.index')}}">Containers</a></li>
                  <li class="breadcrumb-item active" aria-current="page">New</li>
               </ol>
           </nav>
         </div>
      
   </div>
</section>
@endsection

@section('page-data-section')
<section class="page-data-section">
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
      @elseif(session('success'))
      <script type="text/javascript">
	      Swal.fire({
	          icon: 'success',
	          text: "{{session('success')}}",
	          showConfirmButton: false,
	          timer:2000
	        });
      	</script>
    
      @endif
      @php
         $sr=1;
      @endphp
      <div class="row no-gutters">
         <div class="col">
            <div class="row no-gutters justify-content-center">
               <div class="col-sm-8 shadow-lg p-4">
               <form method="post" action="{{ route('containers.store') }}">
        @csrf
        <div class="row no-gutters form-group">    
            
            <div class="col-sm-2 pr-2">
                <label for="name">Vehicle No. *</label>
                <input type="text" class="form-control" name="vehicleNo" placeholder='Vehicle No.' required>
            </div>
            
            <div class="col-sm-5 pr-2">
                <label for="name">Forwarder * <a href='#' data-toggle='modal' data-target='#createModal' class="txt-s ml-3" >New</a></label>
          
                <select name="forwarderId" class="form-control" required>
                <option value=''>Select a forwarder</option>
                @foreach ($forwarders as $forwarder)      
                  <option value='{{$forwarder->id}}'>{{$forwarder->name}}</option>
                @endforeach
              </select>
            </div>
        </div>
          
        <div class="row no-gutters form-group">    
            
            <div class="col-sm-7 pr-2">
                <label for="name">Carrier Name *</label>
                <input type="text" class="form-control" name="carrierName" placeholder='Carrier name' pattern='[a-z A-Z]+' title='Name must contain characters only' required>
            </div>
              
            <div class="col-sm-5">
                <label for="carrierPhone">Carrier Phone</label>
                <input type="text" class="form-control" name="carrierPhone" placeholder="0xxxxxxxxxx" autocomplete='off' pattern='0[0-9]{10}'>
                <div class="form-group text-center hidden p-0 m-0" id='carrier_phone_sub'></div>

            </div>
        </div>
        
        <div class="row no-gutters">    
            <div class="col text-right">
                <button type="submit" class="btn btn-success">Save</button>
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

@section('page-data-section')

<div class="container shadow-lg p-4 mt-4">

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
    
    
</div>

@endsection

@section('modal-section')
  
<!----------------------------------------------------------------------------
                                create modal
------------------------------------------------------------------------------>

  <!-- Insert class Modal -->
  
  <div class="modal fade" id="createModal" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">New Forwarder</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- modal body -->
        <div class="modal-body">
          <div class="container">
            <form id="frm_add_forwarder">
              @csrf
                <div class="row no-gutters form-group">    
                    <div class="col-sm-4 pr-2">
                        <label for="forwarder_name">Name *</label>
                        <input type="text" class="form-control" id="forwarder_name" autocomplete='off' pattern='[a-z A-Z]+' title='Name must contain characters only' placeholder="Forwarder name" required>
                    </div>

                    <div class="col-sm-4 pr-2">
                        <label for="phone">Phone *</label>
                        <input type="text" class="form-control" id="forwarder_phone" autocomplete='off' pattern='0[0-9]{10}' placeholder="0xxxxxxxxxx" required>
                        <div class="txt-s text-center" id='forwarder_phone_sub'>
                    
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="forwarder_email" placeholder="Email">
                    </div>
                
                </div>
                <div class="row no-gutters form-group">    
                    <div class="col">
                        <label for="address">Address</label>
                        <textarea rows='1' type="text" class="form-control" id="forwarder_address" placeholder="Adress"></textarea>
                    </div>
                </div>

                <div class="row no-gutters form-group">    
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

              
            </form>         
          </div>
        </div>
      </div>
    </div> 
  </div>

@endsection

@section('script')
<script type="text/javascript">
   
    $(document).ready(function(){
      

      //set current date and time
    var dt = new Date();
    
    var h = dt.getHours();
    if(h<10) h = '0' + h;
    
    var m=dt.getMinutes();
    if(m<10) m = '0'+ m;

    var time = h + ":" + m;
    
    $("[name='arrivalTime']").val(time);
    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $("[name='carrierPhone']").keyup(function(){     //guide phone format
            var size=11;
            var txt=$("[name='carrierPhone']").val();
            if(txt=='') $('#carrier_phone_sub').hide();
            else{
                              
               var spc='';
               for(i=0; i<size-txt.length; i++){
                  spc+=' -';
               }
               $('#carrier_phone_sub').html(txt+spc);
               $('#carrier_phone_sub').show();

            }
            

            if(txt.length==size) $('#carrier_phone_sub').hide();
            else if(txt.length>size) $('#carrier_phone_sub').css('color','red');
            else $('#carrier_phone_sub').css('color','grey');
            
         });

    
      $("#forwarder_phone").keyup(function(){     //guide phone format
            
            var size=11;
            var txt=$("#forwarder_phone").val();
            if(txt=='') $('#forwarder_phone_sub').hide();
            else{
                              
               var spc='';
               for(i=0; i<size-txt.length; i++){
                  spc+=' -';
               }
               $('#forwarder_phone_sub').html(txt+spc);
               $('#forwarder_phone_sub').show();

            }
            
            if(txt.length==size) $('#forwarder_phone_sub').hide();
            else if(txt.length>size) $('#forwarder_phone_sub').css('color','red');
            else $('#forwarder_phone_sub').css('color','grey');
            
         });
      
      $('#frm_add_forwarder').submit(function(e){
        e.preventDefault();
        var name=$('#forwarder_name').val();
        var phone=$('#forwarder_phone').val();
        var email=$('#forwarder_email').val();
        var address=$.trim($('#forwarder_address').val()); 
        $.ajax({
              type:'POST',
              url:"{{route('ajax_addForwarder')}}",
              data:{
              name:name, 
              phone:phone, 
              email:email,
              address:address
            },
             success:function(data){
                
                $("[name='forwarderId']").html(data.success);
                $('#createModal').modal('hide');
                $("[name='forwarderId']").focus();
             }
          });
      
      });

      
  });

  
    
</script>
 @endsection  


