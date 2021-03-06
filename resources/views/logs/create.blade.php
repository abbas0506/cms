@extends ('user-base')
@section('page-title','New Container')

@section('searchbar')
  <span class="teal">* fields are necessary. Fill and press submit</span>
@endsection

@section('toolbar')
      
@endsection

@section('page')

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
            
            <div class="col-sm-3 pr-2">
                <label for="address">Arrival Date *</label>
              <input type="date" class="form-control" name="arrivalDate" value="{{date('Y-m-d')}}" required>
            </div>
            
            <div class="col-sm-2 ">
                <label for="arrivalTime">Arrival Time *</label>
              <input type="time" class="form-control" name="arrivalTime" id='arrivalTime' value="12:00:00" required>
            </div>
        </div>
          
        <div class="row no-gutters form-group">    
            
            <div class="col-sm-7 pr-2">
                <label for="name">Carrier Name*</label>
                <input type="text" class="form-control" name="carrierName" placeholder='Carrier name' pattern='[a-z A-Z]+' title='Name must contain characters only' required>
            </div>
              
            <div class="col-sm-5">
                <label for="carrierPhone">Carrier Phone</label>
                <input type="text" class="form-control" name="carrierPhone" placeholder="03xxxxxxxxx" autocomplete='off' pattern='03[0-9]{9}'>
                <div class="form-group text-center hidden p-0 m-0" id='carrier_phone_sub'></div>

            </div>
        </div>
        
        <div class="row no-gutters">    
            <div class="col text-right">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
          
    </form>
</div>

@endsection

@section('create-modal')
  
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
                        <input type="text" class="form-control" id="forwarder_phone" autocomplete='off' pattern='03[0-9]{9}' placeholder="03xxxxxxxxx" required>
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


