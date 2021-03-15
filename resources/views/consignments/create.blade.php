
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
                  <li class="breadcrumb-item"><a href="{{route('containers.show', $container->id)}}">{{$container->vehicleNo}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">New Consignment</li>
               </ol>
               <!-- sdjlasdj -->
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
      @endif
      @php
         $sr=1;
      @endphp
      <div class="row no-gutters">
         <div class="col">
            <div class="row no-gutters justify-content-center">
               <div class="col-sm-11 shadow-lg p-4">
                <form method="post" action="{{ route('consignments.store') }}" enctype="multipart/form-data">
            @csrf
            <div>    
               <input type="text" name='containerId' value="{{$container->id}}" hidden>
            </div>
          
            <div class="row no-gutters form-group">    
                <div class="col-sm-2 pr-2">
                    <label for="biltyNo">Bilty No. *</label>
                    <input type="text" class="form-control text-center" name="biltyNo" placeholder="Bilty #" pattern='[0-9][0-9]{1,}' required>
                </div>
                <div class="col-sm-3 pr-2">
                    <label for="name">Consigner* <a href='#' data-toggle='modal' data-target='#createConsignerModal' class="txt-s ml-3" >New</a></label>
                    <select name="consignerId" class="form-control" required>
                        <option value=''>Select a consigner</option>
                        @foreach ($consigners as $consigner)      
                        <option value='{{$consigner->id}}'>{{$consigner->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 pr-2">
                    <label for="name">Consignee* <a href='#' data-toggle='modal' data-target='#createConsigneeModal' class="txt-s ml-3" >New</a></label>
                    <select name="consigneeId" class="form-control" required>
                        <option value=''>Select a consignee</option>
                        @foreach ($consignees as $consignee)      
                        <option value='{{$consignee->id}}'>{{$consignee->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-sm-1">
                    <label for="nItems">Items</label>
                    <input type='text' class="form-control text-center" name="nItems" value="1" pattern='[1-9][0-9]{0,3}' required>
                </div>
                
                <div class="col-sm-3 pl-2">
                    <label for="Description">Description</label>
                    <input class="form-control" name="description" placeholder='In words'>
                </div>
              
            </div>
            
            <div class="row no-gutters form-group border-bottom">    
              <div class="col-sm-12 txt-sb teal">Charges Detail </div>
            </div>
          
            <div class="row no-gutters">
                <div class="col-sm-3 offset-sm-1">
                    <div class="row">
                        <div class="col my-auto strong">Vehicle *</div>
                        <div class="col">
                            <input type="text" class="form-control text-center" name="vehicleCharges" value='0' pattern='0|[1-9][0-9]{0,5}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Loading-1 *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="loadOneCharges" value='0' pattern='0|[1-9][0-9]{0,5}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Bilty-1 *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="biltyOneCharges" value='70' pattern='0|[1-9][0-9]{0,5}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Insurance *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="insurance" value='30' pattern='0|[1-9][0-9]{0,3}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Cart-1 *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="cartOneCharges" value='0' pattern='0|[1-9][0-9]{0,3}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Others</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="otherCharges" value='0' pattern='0|[1-9][0-9]{0,3}'>
                        </div>
                    </div>
                    <div class="row mt-3 brown strong">
                        <div class="col-sm-6 my-auto">Subtotal-1:</div>
                        <div class="col-sm-6 my-auto text-center" id='forwarderAmount'>0</div>
                    </div>



                </div>
                
                
                <div class="col-sm-3 offset-sm-1">

                    <div class="row">
                        <div class="col my-auto strong">Unloading *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="unloadCharges" value='0' pattern='0|[1-9][0-9]{0,3}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Bilty-2 *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="biltyTwoCharges" value='0' pattern='0|[1-9][0-9]{0,3}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Cart-2 *</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="cartTwoCharges" value='0' pattern='0|[1-9][0-9]{0,3}' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Loading-2</div>
                        <div class="col">
                            <input type="text" class="form-control charges text-center" name="loadTwoCharges" pattern='0|[1-9][0-9]{0,3}' value='0'>
                        </div>
                    </div>

                    
                    <div class="row mt-2 brown strong">
                        <div class="col-sm-6 my-auto">Subtotal-2:</div>
                        <div class="col-sm-6 my-auto text-center" id='subtotal'>0</div>
                    </div>
                    
                </div>
                <div class='col-sm-3 my-bg-success offset-sm-1' style='top:100px; height:100px'>
                        
                        <div class="text-center txt-lb ">Grand Total:</div>
                        <div class="text-center display-4" id='totalAmount'>0</div>
                        <div class="text-right mt-2"><button type="submit" class="btn btn-block btn-success">Submit</button></div>
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


@section('modal-section')
  
<!----------------------------------------------------------------------------
                                Create Consigner modal
------------------------------------------------------------------------------>

  <!-- Insert class Modal -->
  <div class="modal fade" id="createConsignerModal" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">New Consigner</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- modal body -->
        <div class="modal-body">
          <div class="container">
            <form  id="frm_add_consigner">
              @csrf
              <div class="row form-group">    
                  
                <div class="col-sm-4 pr-2">
                  <label for="consigner_name">Name *</label>
                  <input type="text" class="form-control" id="consigner_name" autocomplete='off' pattern='[a-z A-Z]+' placeholder="Alphabets only" required>

                </div>
                <div class="col-sm-4 pr-2">
                  <label for="phone">Phone *</label>
                  <input type="text" class="form-control" id="consigner_phone" autocomplete='off' pattern='0[0-9]{10}' placeholder="0xxxxxxxxxx" required>
                  
                  <div class="form-group hidden text-center" id='consigner_phone_sub'></div>

                </div>
                <div class="col-sm-4">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="consigner_email" placeholder="abc@mail.com">
                </div>
                  
              </div>
              
              <div class="form-group">    
                  <label for="address">Address</label>
                  <textarea rows='1' type="text" class="form-control" id="consigner_address" placeholder="Adress"></textarea>
              </div>

              <button type="submit" class="btn btn-success">Submit</button>
            </form>         
          </div>
        </div>
      </div>
    </div> 
  </div>



<!----------------------------------------------------------------------------
                                Create Consignee modal
------------------------------------------------------------------------------>

  <!-- Insert class Modal -->
  <div class="modal fade" id="createConsigneeModal" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">New Consignee</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- modal body -->
        <div class="modal-body">
          <div class="container">
            <form id="frm_add_consignee">
              @csrf
                <div class="row form-group">    
                    <div class="col-sm-4 pr-2">
                        <label for="consigner_name">Name *</label>
                        <input type="text" class="form-control" id="consignee_name" autocomplete='off' pattern='[a-z A-Z]+' placeholder="Alphabets only" required>
                    </div>

                    <div class="col-sm-4 pr-2">
                        <label for="phone">Phone *</label>
                        <input type="text" class="form-control" id="consignee_phone" autocomplete='off' pattern='0[0-9]{10}' placeholder="0xxxxxxxxxx" required>
                        <div class="form-group text-center hidden" id='consignee_phone_sub'></div>
              
                    </div>
                    <div class="col-sm-4">   
                        <label for="consignee_email">Email</label>
                        <input type="email" class="form-control" id="consignee_email" placeholder="abc@mail.com">
                    </div>
                </div>
                <div class="form-group">    
                    
                    <label for="address">Address</label>
                    <textarea row='2' type="text" class="form-control" id="consignee_address" placeholder="Adress"></textarea>
              </div>


              <button type="submit" class="btn btn-success">Submit</button>
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
    
    $("[name='receiveTime']").val(time);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $("#consigner_phone").keyup(function(){     //guide phone format
            
            var size=11;
            var txt=$("#consigner_phone").val();
            if(txt=='') $('#consigner_phone_sub').hide();
            else{
                              
               var spc='';
               for(i=0; i<size-txt.length; i++){
                  spc+=' -';
               }
               $('#consigner_phone_sub').html(txt+spc);
               $('#consigner_phone_sub').show();

            }
            

            if(txt.length==size) $('#consigner_phone_sub').hide();
            else if(txt.length>size) $('#consigner_phone_sub').css('color','red');
            else $('#consigner_phone_sub').css('color','grey');
            
         });

    $("#consignee_phone").keyup(function(){     //guide phone format
            
            var size=11;
            var txt=$("#consignee_phone").val();
            if(txt=='') $('#consignee_phone_sub').hide();
            else{
                              
               var spc='';
               for(i=0; i<size-txt.length; i++){
                  spc+=' -';
               }
               $('#consignee_phone_sub').html(txt+spc);
               $('#consignee_phone_sub').show();

            }
            

            if(txt.length==size) $('#consignee_phone_sub').hide();
            else if(txt.length>size) $('#consignee_phone_sub').css('color','red');
            else $('#consignee_phone_sub').css('color','grey');
            
         });
   
    $("[name='insurance']").keyup(function(e){calcCharges();});
    $("[name='biltyOneCharges']").keyup(function(e){
        $("[name='biltyTwoCharges']").val($(this).val());
        calcCharges();
    });
    $("[name='biltyTwoCharges']").keyup(function(e){calcCharges();});
    $("[name='cartOneCharges']").keyup(function(e){
        $("[name='cartTwoCharges']").val($(this).val());
        calcCharges();
    });
    $("[name='cartTwoCharges']").keyup(function(e){calcCharges();});
    $("[name='otherCharges']").keyup(function(e){calcCharges();});
    $("[name='loadOneCharges']").keyup(function(e){
        $("[name='unloadCharges']").val($(this).val());
        calcCharges();
    });
    $("[name='loadTwoCharges']").keyup(function(e){
        calcCharges();
    });
    $("[name='unloadCharges']").keyup(function(e){calcCharges();});
    $("[name='vehicleCharges']").keyup(function(e){calcCharges();});

    $('#frm_add_consigner').submit(function(e){
        e.preventDefault();
        var name=$('#consigner_name').val();
        var phone=$('#consigner_phone').val();
        var email=$('#consigner_email').val();
        var address=$.trim($('#consigner_address').val()); 
        
        $.ajax({
            type:'POST',
            url:"{{route('ajax_addConsigner')}}",
            data:{
                name:name, 
                phone:phone, 
                email:email,
                address:address
                },
                success:function(data){
                  $("[name='consignerId']").html(data.success);
                  $('#createConsignerModal').modal('hide');
                  $("[name='consignerId']").focus();
                }
        });
    });

    $('#frm_add_consignee').submit(function(e){
        
        e.preventDefault();
        var name=$('#consignee_name').val();
        var phone=$('#consignee_phone').val();
        var email=$('#consignee_email').val();
        var address=$.trim($('#consignee_address').val()); 
                
            
        $.ajax({
                type:'POST',
                url:"{{route('ajax_addConsignee')}}",
                data:{
                name:name, 
                phone:phone, 
                email:email,
                address:address
              },
               success:function(data){
                  
                  $("[name='consigneeId']").html(data.success);
                  $('#createConsigneeModal').modal('hide');
                  $("[name='consigneeId']").focus();
               }
            });


    });

});

function calcCharges(){

    var vehicleCharges=$("[name='vehicleCharges']").val();
    var loadOneCharges=$("[name='loadOneCharges']").val();
    var biltyOneCharges=$("[name='biltyOneCharges']").val();
    var insurance=$("[name='insurance']").val();
    var cartOneCharges=$("[name='cartOneCharges']").val();
    var otherCharges=$("[name='otherCharges']").val();
        
    var unloadCharges=$("[name='unloadCharges']").val();
    var biltyTwoCharges=$("[name='biltyTwoCharges']").val();
    var cartTwoCharges=$("[name='cartTwoCharges']").val();
    var loadTwoCharges=$("[name='loadTwoCharges']").val();
    
    if(vehicleCharges=='') vehicleCharges=0;
    if(loadOneCharges=='') loadOneCharges=0;
    if(biltyOneCharges=='') biltyOneCharges=0;
    if(insurance=='') insurance=0;
    if(cartOneCharges=='') cartOneCharges=0;
    if(otherCharges=='') otherCharges=0;
    if(unloadCharges=='')unloadCharges=0;
    if(biltyTwoCharges=='') biltyTwoCharges=0;
    if(cartTwoCharges=='') cartTwoCharges=0;
    if(loadTwoCharges=='') loadTwoCharges=0;


    var forwarderAmount=parseInt(vehicleCharges)+parseInt(loadOneCharges)+parseInt(biltyOneCharges)+parseInt(insurance)+parseInt(cartOneCharges)+parseInt(otherCharges);
    
    var subtotal = parseInt(unloadCharges)+parseInt(biltyTwoCharges)+parseInt(cartTwoCharges)+parseInt(loadTwoCharges);
    

    var total=forwarderAmount+subtotal;

    $('#forwarderAmount').html(forwarderAmount);
    $('#subtotal').html(subtotal);
    $('#totalAmount').html(total);
}
  
</script>
@endsection

