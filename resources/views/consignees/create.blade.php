@extends ('admin-base')
@section('page-title','New Consignee')
@section('searchbar')
   @parent
@endsection

@section('toolbar')
  
  <a href="{{route('consignees.index')}}"><i class="fa fa-eye txt-s"></i></a> 
     
@endsection

@section('page')

<div class="container w-75">
<div class="card shadow-lg">
 <div class="card-header txt-mb">
    * fields are necessary
  </div>

  <div class="card-body pl-5 pr-5">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('consignees.store') }}">
          @csrf
          <div class="form-group">    
              <label for="name">Name *</label>
              <input type="text" class="form-control" name="name" autocomplete='off' autofocus pattern='[a-z A-Z]+' title='Name must contain characters only' required>
          </div>
          <div class="form-group">
              <label for="phone">Phone *</label>
              <input type="text" class="form-control" name="phone" autocomplete='off' pattern='03[0-9]{9}' title='format: 03xx1234567'>

          </div>
          <div class="form-group hidden" id='phone_sub'>
               <div class="txt-s text-center" id='phone_sub_text'>
                format: 03421234567
               </div>
          </div>
          <div class="form-group">    
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email">
          </div>
          <div class="form-group">    
              <label for="address">Address</label>
              <textarea row='3' type="text" class="form-control" name="address"></textarea>
          </div>
          
          <button type="submit" class="btn btn-info">Submit</button>
      </form>
  </div>
</div>
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

  });

</script>
@endsection
