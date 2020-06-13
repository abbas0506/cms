@extends ('user-base')
@section('page-title')
  Edit Container
@endsection

@section('searchbar')
   @parent
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
      <br>
    @endif
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
                <input type="text" class="form-control" name="carrierPhone" placeholder="03xxxxxxxxx" autocomplete='off' pattern='03[0-9]{9}' value='{{$container->carrierPhone}}'>
                <div class="form-group text-center hidden p-0 m-0" id='carrier_phone_sub'></div>

            </div>
        </div>
        
        <div class="row no-gutters form-group">    
            <div class="col text-right">
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </div>
    </form>
</div>

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
