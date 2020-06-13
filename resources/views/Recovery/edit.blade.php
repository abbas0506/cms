@extends ('user-base')
@section('page-title')
  Edit Recovery
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
    <form  method="post" action="{{route('recoveries.update', $recovery->id)}}">
		@csrf
        @method('PATCH')
		<div class="row no-gutters form-group">    
		    <div class="col-sm-2 pr-2">
			    <label for="amount">Amount *</label>
			    <input type="text" class="form-control" name="amount" autocomplete='off' pattern='[0-9]{1,5}([.][0-9]{1,5}){0,1}' placeholder="amount" required value='{{$recovery->amount}}'>
            </div>
		    <div class="col-sm-10 ">
			    <label for="phone">Description</label>
			    <input type="text" class="form-control" name="description" autocomplete='off' value='{{$recovery->description}}'>
		    </div>
		</div> 
		<div class=" row no-gutters form-group">
		    <div class="col-sm-10">
			    <strong>* Amount</strong> &nbsp should be in the range of 1 - 99999.99
			</div> 
			<div class="col-sm-2 text-right">
			    <button type="submit" class="btn btn-success">Submit</button>
			</div>  
		</div>
	</form>
</div>

@endsection

