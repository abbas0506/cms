
@extends ('user-base')
@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('users.index')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('containers.index')}}">Containers</a></li>
                  <li class="breadcrumb-item"><a href="{{route('containers.show', $consignment->container->id)}}">{{$consignment->container->vehicleNo}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Consignment</li>
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
     @endif
      @php
         $sr=1;
      @endphp
      <div class="row no-gutters">
         <div class="col">
            <div class="row no-gutters justify-content-center">
               <div class="col-sm-11 shadow-lg p-4">
                  <form method="post" action="{{ route('consignments.update', $consignment->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
            <div class="row no-gutters form-group">    
                <div class="col-sm-2 pr-2">
                    <label for="biltyNo">Bilty No. </label><div class="brown txt-lb"> {{$consignment->biltyNo}}</div>
                    
                </div>
                <div class="col-sm-3 pr-2">
                    <label for="name">Consigner* <a href='#' data-toggle='modal' data-target='#createConsignerModal' class="txt-s ml-3" >New</a></label>
                    <select name="consignerId" class="form-control" required>
                        <option value=''>Select a consigner</option>
                        @foreach ($consigners as $consigner)      
                            @if($consigner->id==$consignment->consignerId)
                                <option value='{{$consigner->id}}' selected>{{$consigner->name}}</option>
                            @else
                                <option value='{{$consigner->id}}'>{{$consigner->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 pr-2">
                    <label for="name">Consignee* <a href='#' data-toggle='modal' data-target='#createConsigneeModal' class="txt-s ml-3" >New</a></label>
                    <select name="consigneeId" class="form-control" required>
                        <option value=''>Select a consignee</option>
                        @foreach ($consignees as $consignee)      
                        @if($consignee->id==$consignment->consigneeId)
                                <option value='{{$consignee->id}}' selected>{{$consignee->name}}</option>
                            @else
                                <option value='{{$consignee->id}}'>{{$consignee->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                
                <div class="col-sm-1">
                    <label for="nItems">Items</label>
                    <input type='text' pattern="[1-9][0-9]{0,2}" class="form-control text-center" name="nItems" value="{{$consignment->nItems}}">
                </div>
                
                <div class="col-sm-3 pl-2">
                    <label for="Description">Description</label>
                    <input class="form-control" name="description" placeholder='e.g 4 cartons' value="{{$consignment->description}}">
                </div>
              
            </div>
            
            <div class="row no-gutters form-group border-bottom">    
              <div class="col-sm-12 txt-sb teal">Charges Detail </div>
            </div>
          
            <div class="row no-gutters">
                <div class="col-sm-4 pl-5">
                    <div class="row">
                        <div class="col my-auto strong">Vehicle *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center" name="vehicleCharges" value="{{$consignment->vehicleCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Loading-1 *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="loadOneCharges" value="{{$consignment->loadOneCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Bilty-1 *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="biltyOneCharges" value="{{$consignment->biltyOneCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Insurance *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="insurance" value="{{$consignment->insurance}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Cart-1 *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="cartOneCharges" value="{{$consignment->cartOneCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Others</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="otherCharges" value="{{$consignment->otherCharges}}">
                        </div>
                    </div>
                    <div class="row mt-3 blue strong">
                        <div class="col-sm-6 my-auto">Subtotal-1:</div>
                        <div class="col-sm-6 my-auto text-center" id='forwarderAmount'>0</div>
                    </div>



                </div>
                
                
                <div class="col-sm-4 pl-5" style="margin-top: 35px;">

                    <div class="row">
                        <div class="col my-auto strong">Unloading *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="unloadCharges" value="{{$consignment->unloadCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Bilty-2 *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="biltyTwoCharges" value="{{$consignment->biltyTwoCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Cart-2 *</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="cartTwoCharges" value="{{$consignment->cartTwoCharges}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col my-auto strong">Loading-2</div>
                        <div class="col">
                            <input type="text" pattern="0|[1-9][0-9]{0,3}" class="form-control text-center charges" name="loadTwoCharges" value="{{$consignment->loadTwoCharges}}">
                        </div>
                    </div>

                    
                    <div class="row mt-2 blue
                     strong">
                        <div class="col-sm-6 my-auto">Subtotal-2:</div>
                        <div class="col-sm-6 my-auto text-center" id='subtotal'>0</div>
                    </div>
                    

                    <div class="row mt-4 red strong border-top">
                        <div class="col-sm-6 my-auto">Grand Total:</div>
                        <div class="col-sm-6 my-auto text-center" id='totalAmount'>0</div>
                    </div>

                </div>
                <div class="col-sm-4 pl-5">
                    <div class="row form-group">
                        <div class="col-sm-4 my-auto strong">Receiver :</div>
                        <div class="col-sm-8"><input type="text" class="form-control" name="receiverName" placeholder='Alpahbets only' value="{{ $consignment->receiverName }}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-8 offset-sm-4">
                            <center>
                            @if($consignment->receiverPic)
                                <img src="{{asset('uploads')}}/{{$consignment->receiverPic}}" width='120' height="120" class="rounded-circle">

                            @else
                                <div  class="rounded-circle mb-2 text-center" style="width: 120px; height: 120px; background-color:#F6D5C2; padding-top: 40px">No Image</div>

                            @endif
                            </center>
                            
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4 my-auto strong">Picture :</div>
                        <div class="col-sm-8"><input type="file" class="form-control border-0" name="receiverPic" placeholder='Picture' value="{{ $consignment->receiverPic}}" style="padding:3px !important"></div>
                    </div>
                </div>

            </div>

            <div class="row no-gutters form-group">
                <div class="col text-right"><button type="submit" class="btn btn-success btn-sm">Save</button></div>
                
            </div>

            
        </form>
        </div>   
            </div>
         </div>
      </div>
   </div>
</section>

@endsection


@section('create-modal')
  
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
                  <input type="text" class="form-control" id="consigner_phone" autocomplete='off' pattern='03[0-9]{9}' placeholder="03xxxxxxxxx" required>
                  
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
                        <input type="text" class="form-control" id="consignee_phone" autocomplete='off' pattern='03[0-9]{9}' placeholder="03xxxxxxxxx" required>
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
    
    calcCharges();
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

