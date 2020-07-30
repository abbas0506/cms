@extends ('user-base')
@section('page-title','Consignments')
@section('searchbar')
	<form method='post' action="{{url('searchByDates')}}">
		@csrf
		@method('POST')
		<div class="row">
			<div class="col-sm-3 my-auto">
				From <input type="date" class="form-control" name="from" value="
				@if(!$consignments->isEmpty())
					{{$consignments->min('created_at')->toDateString()}}
				@endif
				"> 
			</div>
			<div class="col-sm-3 my-auto">
				To <input type="date" class="form-control" name="to" value="
				@if(!$consignments->isEmpty())
					{{$consignments->max('created_at')->toDateString()}}
				@endif
				"> 
			</div>
			<div class="col-sm-2 my-auto">
				<button type="submit" class="btn btn-sm btn-success mt-4"><i class="fas fa-search"></i></button>
			</div>
		
		</div>
	</form>
	
	 
@endsection

@section('page')
	@if(session('success'))
    	<script type="text/javascript">
	      Swal.fire({
	          icon: 'success',
	          text: "{{session('success')}}",
	          showConfirmButton: false,
	          timer:2000
	        });
      	</script>
    @endif

	<div class="container border border-rounded p-4 mt-4 mb-4">
		<div class="row">
			<div class="col-sm-4 offset-sm-3 text-center my-auto">
				<i class="fas fa-search text-secondary icon-l"></i>
				<input type="text" id="filter" class="form-control text-center round" placeholder="Type biltyNo or consigne name">
			</div>
			<div class="col-sm-2 my-auto teal">
				<i class='fas fa-toggle-off'></i>
				<i class='fas fa-toggle-on hidden'></i>
				&nbsp; Pending Only
			</div>
			<input type="text" id='_status' hidden>
		</div>
			
		<table class="table table-striped mt-4">
			<thead>
				<tr class="strong">
					<td>Date</td>
					<td>Bilty No.</td>
					<td>Consignee</td>
					<td>Description</td>
					<td>Amount</td>
					<td>Delivery</td>
					<td class="text-center"><i class="fas fa-bars"></i></td>
				</tr>
			</thead>
			<tbody>
				@foreach($consignments as $consignment)
				<tr>
					<td class="hidden">{{$consignment->id}}</td>
					<td>{{$consignment->created_at->toDateString()}}</td>
					<td>{{$consignment->biltyNo}}</td>
					<td>{{$consignment->consignee->name}}</td>
					<td>{{$consignment->description}}</td>
					<td>{{$consignment->getTotal()}}</td>
					<td>
						@if($consignment->getStatus()=='Pending')
							<i class="fas fa-circle micro red pr-1"></i>
							<a href="#" data-toggle='modal' data-target='#handoverModal'>Handover</a>
						@else
							<i class="fas fa-check green"></i>
						@endif
					</td>
					<td class="hidden">{{$consignment->getStatus()}}</td>
						<form action="{{ route('consignments.destroy', $consignment->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
							<td class='text-center'>
								<a href="{{ route('consignments.show', $consignment->id)}}" class='btn btn-sm btn-link text-info'><i class="far fa-eye"></i></a>
								<a href="{{ route('consignments.edit', $consignment->id)}}" class="btn btn-sm btn-link text-success"><i class="fas fa-pencil-alt"></i></a>
								@csrf
								@method('DELETE')
								<button class="btn btn-sm btn-link text-danger txt-s" type="submit"><i class="far fa-trash-alt"></i></button>
							</td>
						</form>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<!----------------------------------------------------------------------------
									Handover modal
	------------------------------------------------------------------------------>

	<!-- Insert class Modal -->
	<div class="modal fade" id="handoverModal" role="dialog" >
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Handover Consignment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<div class="container">
					<form method="post" action="{{ url('handover') }}" enctype="multipart/form-data">
						@csrf
						@method('POST')
							<div class="row no-gutters form-group">    
								<input type="text" name='consignmentId' value='' hidden>  
								<div class="col">
									<label for="receiverName">Receiver *</label>
									<input type="text" class="form-control" name="receiverName" autocomplete='off'  placeholder="Receiver name" required>
								</div>
								
							</div> 
							<div class="row no-gutters form-group">
	                            <div class="col-sm-3 strong my-auto">Receiver Pic.</div>
	                            <div class="col">
	                            	<input type="file" class="form-control border-0" name="receiverPic" placeholder='Pic'  style="padding: 3px !important">
	                            </div>
	                        </div>
							<div class=" row no-gutters form-group">
								<div class="col text-right">
								<button type="submit" class="btn btn-primary">Submit</button>
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
		$('#_status').val('*');	//no filter attrib
		
		$("#filter").on("keyup", function() {
	      	search();  
			
		});
	
		//handover event
		$("table tbody tr").click(function() {
	        var id = $(this).find('td:eq(0)').text();
			$("[name='consignmentId']").val(id);
		});
		$('.fa-toggle-off').click(function(){
			$('.fa-toggle-on').show();
			$('.fa-toggle-off').hide();

			//filter table for pending only
			$('#_status').val('pending');
			
			search();
		});
		
		$('.fa-toggle-on').click(function(){
			$('.fa-toggle-off').show();
			$('.fa-toggle-on').hide();
			
			$('#_status').val('*');
			search();
			  
		});



	});
	function search(){
		
		var txt = $('#filter').val().toLowerCase();	//text filter
		var status=$('#_status').val();				//status filter
		$("table tbody tr").each(function() {
				
			if(status=='pending'){
				if(($(this).children().eq(2).text().toLowerCase().includes(txt)||$(this).children().eq(3).text().toLowerCase().includes(txt))
					&& $(this).children().eq(7).text().toLowerCase()=='pending')
	        		$(this).show();
	        	else
	          		$(this).hide();
			}else{
				if($(this).children().eq(2).text().toLowerCase().includes(txt)||$(this).children().eq(3).text().toLowerCase().includes(txt))
	        		$(this).show();
	        	else
	          		$(this).hide();
			}
			
	      	});
	}

	 
</script>

@endsection