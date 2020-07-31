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
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-3 offset-col-5 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
              <a href="{{route('containers.create')}}">
                  <div class="icon-xl text-success"><i class="fa fa-plus-circle"></i></div>
                  <div class="micro">New Container</div>
               </a>
            </div>
            
         </div>
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
               <div class="col-sm-8 shadow-lg p-4">
                  <form method="post" action="{{ route('containers.update', $container->id) }}">
                     @csrf
                     @method('PATCH')
                     <div class="row no-gutters form-group">      
                           <div class="col-sm-2 pr-2">
                              <label for="name">Vehicle No. *</label>
                              <input type="text" class="form-control" name="vehicleNo" placeholder='Vehicle No.' value='{{$container->vehicleNo}}' required>
                           </div>
                           
                           <div class="col-sm-5 pr-2">
                              <label for="name">Forwarder</label>
                              <input class="form-control" readonly value="{{$container->forwarder->name}}">
                           </div>
                     </div>
                        
                     <div class="row no-gutters form-group">    
                           
                           <div class="col-sm-7 pr-2">
                              <label for="name">Carrier Name*</label>
                              <input type="text" class="form-control" name="carrierName" placeholder='Carrier name' pattern='[a-z A-Z]+' title='Name must contain characters only' value='{{$container->carrierName}}' required>
                           </div>
                           
                           <div class="col-sm-5">
                              <label for="carrierPhone">Carrier Phone</label>
                              <input type="text" class="form-control" name="carrierPhone" placeholder="0xxxxxxxxxx" autocomplete='off' pattern='0[0-9]{10}' value='{{$container->carrierPhone}}'>
                              <div class="form-group text-center hidden p-0 m-0" id='carrier_phone_sub'></div>

                           </div>
                     </div>
                     
                     <div class="row no-gutters">    
                           <div class="col text-right">
                              <button type="submit" class="btn btn-success btn-sm">Save</button>
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
    
   // $("[name='departTime']").pickatime({});

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

  });

</script>
@endsection
