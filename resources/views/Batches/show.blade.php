@extends ('user-base')
@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{route('batches.index')}}">Batches</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$batch->id}}</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-3 offset-col-5 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
            	<a href="#" data-toggle="modal" data-target="#newRecovery">
						<div class="icon-xl text-success"><i class="fa fa-plus-circle"></i></div>
                  <div class="micro">New Recovery</div>
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
         $sr=0;
      @endphp
      <div class="row no-gutters">
         <div class="col">
				<div class="row no-gutters justify-content-center">
               <div class="col-sm-8">
						<div class="row no-gutters justify-content-center mb-2">
							<div class="col-sm-6 brown ">Dated: {{$batch->created_at->format('d/m/Y')}}</div>
							<div class="col-sm-6 txt-lb teal">Amount: {{$batch->getTotal()}}</div>
						</div>
						<div class="row">
							<table class="table table-striped">
								<thead>
											<tr class="strong">
												<td>Sr</td>
												<td>Consignee</td>
												<td>Amount</td>
												<td>Description</td>
												<td class="text-center"><i class="fa fa-bars"></td>
											</tr>
								</thead>
								<tbody>
											@foreach($batch->recoveries as $recovery)
											<tr>
												<td>{{++$sr}}</td>
												<td>{{$recovery->consignee->name}}</td>
												<td>{{$recovery->amount}}</td>
												<td>{{$recovery->description}}</td>
												
												<form action="{{ route('batchedRecoveries.destroy', $recovery->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
													<td class='text-center'>
														<a href="{{ route('batchedRecoveries.edit', $recovery->id)}}" class='btn btn-sm btn-link text-success'><i class="fas fa-pen"></i></a>
														@csrf
														@method('DELETE')
														<button class="btn btn-sm btn-link text-danger" type="submit"><i class="far fa-trash-alt"></i></button>
													</td>
												</form> 
												
											</tr>
											@endforeach

											
								</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>   
   </div>
</section>
@endsection

@section('modal-section')
	<!----------------------------------------------------------------------------
									New Recovery modal
	------------------------------------------------------------------------------>

	<!-- Insert class Modal -->
	<div class="modal fade" id="newRecovery" role="dialog" >
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">New Recovery</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- modal body -->
				<div class="modal-body">
				<div class="container">
					<form  method="post" action="{{route('batchedRecoveries.store')}}">
					@csrf
						<div class="row no-gutters form-group">    
							<div class="col-sm-4 pr-2">
								<input type="text" name='batchId' value='{{$batch->id}}' hidden >  
								<label for="consignee">Select a consignee *</label>
								<select name="consigneeId" class="form-control" required>
									<option value=''>Select a consignee</option>
									@foreach ($consignees as $consignee)      
										<option value='{{$consignee->id}}'>{{$consignee->name}}</option>
									@endforeach
									</select>
							</div>
							
							<div class="col-sm-2 pr-2">
								<label for="amount">Amount *</label>
								<input type="text" class="form-control" name="amount" autocomplete='off' pattern='[0-9]{1,5}([.][0-9]{1,5}){0,1}' placeholder="amount" required>

							</div>
							<div class="col-sm-6 ">
							<label for="phone">Description</label>
							<input type="text" class="form-control" name="description" autocomplete='off'>
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
@endsection

@section('script')
<script type="text/javascript">
	
	$(document).ready(function(){
		$("#filter").on("keyup", function() {
			var txt = $(this).val().toLowerCase();
			$("table tbody tr").each(function() {
				if($(this).children().eq(0).text().toLowerCase().includes(txt)||$(this).children().eq(2).text().toLowerCase().includes(txt))
					$(this).show();
				else
					$(this).hide();
		  });
		});
	 
	});

</script>

@endsection