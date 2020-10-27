@extends ('user-base')
@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-6 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{route('recoveries.index')}}">Recovery List</a></li>
						<li class="breadcrumb-item"><a href="{{route('recoveries.show', $recovery->consignee->id)}}">{{$recovery->consignee->name}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Recovery</li>
               </ol>
           </nav>
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
									<input type="text" class="form-control" name="description" autocomplete='off' value='{{$recovery->description}}' placeholder="In words">
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
      <br>
    @endif
    
</div>

@endsection

