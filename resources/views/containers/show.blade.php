@extends ('user-base')
@section('page-title','Container Detail')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type bilty no. or consignee">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
		
	<a href="{{ url('consignments_create', $container->id)}}" class='btn btn-success btn-sm'><i class="fa fa-plus"></i></a>
	<a target='_blank' href="#" class='btn btn-primary btn-sm'><i class="fa fa-print"></i></a>
		 
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
			
		<div class="row no-gutters pb-2">
			<div class="col-sm-3 p-3 my-bg-success text-center text-success">
				<div class="strong mb-1 "><i class="fas fa-truck"></i></div>
				<div>{{$container->vehicleNo}}</div>
			</div>
			<div class="col-sm-3 p-3 my-bg-info text-center text-primary">
				<div class="strong mb-1"><i class="far fa-user"></i></div>
				<div>{{$container->carrierName}}</div>					
			</div>
			<div class="col-sm-3 p-3 my-bg-danger text-center text-primary">
				<div class="strong mb-1"><i class="fas fa-rupee-sign"></i></div>
				<div>{{$container->getTotal()}}</div>					
			</div>
			<div class="col-sm-3 p-3 my-bg-info text-center text-primary">
				<div class="strong mb-1"><i class="far fa-clock"></i></div>
				<div>{{$container->created_at}}</div>					
			</div>
				
		</div>

		<ul class="nav nav-tabs mt-4">
			<li class="nav-item">
				<a class='nav-link active' data-toggle="tab" href="#consignments">Consignments</a>
			</li>
			<li class='nav-item'>
				<a class='nav-link' data-toggle="tab" href="#carrierPayments">Carrier Payment</a>
			</li>
		</ul>

		<div class="tab-content mt-4">
			<div class="tab-pane container active" id="consignments">
				<table class="table table-striped" id='tblConsignments'>
					<thead>
						<tr class="txt-mb">
							<td>Bilty No.</td>
							<td>Consigner</td>
							<td>Consignee</td>
							<td>Description</td>
							<td>Amount</td>
							<td>Status</td>
							<td class="text-center"><i class="fas fa-cogs"></i></td>
						</tr>
					</thead>
					<tbody>
						@foreach($container->consignments as $consignment)
						<tr>
							<td class='hidden'>{{$consignment->id}}</td>
							<td>{{$consignment->biltyNo}}</td>
							<td>{{$consignment->consigner->name}}</td>
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
							<form action="{{ route('consignments.destroy', $consignment->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
								<td class='text-center'>
									<a href="{{ route('consignments.show', $consignment->id)}}" class='btn btn-sm btn-info'><i class="far fa-eye"></i></a>
									<a href="{{ route('consignments.edit', $consignment->id)}}" class='btn btn-primary btn-sm'><i class="fas fa-pencil-alt"></i></a>
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-sm" type="submit"><i class="far fa-trash-alt"></i></button>
								</td>
							</form>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>


			<div class="tab-pane container" id="carrierPayments">
				<div class="row no-gutters mt-4">
					<div class="col-sm-4 offset-sm-2">
						<div class="row no-gutters">
							<div class="col-sm-6 strong">Carrier Amount</div>
							<div class="col-sm-6 text-right ">{{$container->getCarrierFraction()}}</div>
						</div>
						<div class="row no-gutters">
							<div class="col-sm-6 strong">Paid</div>
							<div class="col-sm-6 text-right">{{$container->getPaid()}}</div>
						</div>
						<div class="row no-gutters border-top mt-2">
							<div class="col-sm-6 strong">Arears</div>
							<div class="col-sm-6 text-right">{{$container->getCarrierFraction()-$container->getPaid()}}</div>
						</div>
					</div>
									
					<div class="col-sm-2 offset-sm-2 text-center">
						<form method="post" action="{{ route('payments.store') }}">
							@csrf
							<div>
								<input type="text" name="containerId" value="{{$container->id}}" hidden>
								<input type="text" class="form-control text-center" name="amount" placeholder="arears" value='{{$container->getCarrierFraction()-$container->getPaid()}}' @if($container->getPaid() >= $container->getCarrierFraction())
									disabled 
								@endif
								>
							</div>
							<div class="text-right">
								<button class="btn btn-success btn-sm btn-block mt-2" @if($container->getPaid() >= $container->getTotal())
									disabled 
								@endif
								>Pay &nbsp <i class="fas fa-hand-holding-usd"></i></button>
							
							</div>
						</form>
					</div>
				</div>
				<table class="table table-striped mt-4" id='tblPayments'>
					<thead>
						<tr class="txt-mb">
							<td>Sr</td>
							<td>Date</td>
							<td>Amount</td>
							<td class="text-center"><i class="fas fa-cogs"></i></td>
						</tr>
					</thead>
					<tbody>
						@php
							$sr=0
						@endphp
						@foreach($container->payments as $payment)
						<tr>
							<td class='hidden'>{{$payment->id}}</td>
							<td>{{++$sr}}</td>
							<td>{{$payment->created_at}}</td>
							<td>{{$payment->amount}}</td>
							<form action="{{ route('payments.destroy', $payment->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
								<td class='text-center'>
									<a href="#" data-toggle='modal' data-target='#paymentsModal' class='btn btn-primary btn-sm'><i class="fas fa-pencil-alt"></i></a>
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-sm" type="submit"><i class="far fa-trash-alt"></i></button>
								</td>
							</form>
						</tr>
						@endforeach

					</tbody>
				</table>

		</div>
	
	</div>
</div>

	<!----------------------------------------------------------------------------
									Edit Payment modal
	------------------------------------------------------------------------------>

	<!-- Insert class Modal -->
	<div class="modal fade" id="paymentsModal" role="dialog" >
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Edit Payment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<div class="container">
						<form  method="post" action="{{route('payments.update', 0)}}">
						@csrf
						@method('PATCH')
							<div class="row no-gutters form-group">    
								<input type="text" name='id' value='' hidden >  
								<div class="col">
									<label for="amount">Amount *</label>
									<input type="text" class="form-control" name="amount" autocomplete='off' pattern='[0-9]{1,5}([.][0-9]{1,5}){0,1}' placeholder="amount" required>
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
		$("#filter").on("keyup", function() {
	      	var txt = $(this).val().toLowerCase();
	      	$("table tbody tr").each(function() {
	        	if($(this).children().eq(1).text().toLowerCase().includes(txt)||$(this).children().eq(3).text().toLowerCase().includes(txt))
	          		$(this).show();
	        	else
	          		$(this).hide();
	      	});
	    });

		$("#tblPayments tbody tr").click(function() {
	        var id = $(this).find('td:eq(0)').text();
			$("[name='id']").val(id);
			$("[name='amount']").val($(this).find('td:eq(3)').text());
	    });

		$("#tblConsignments tbody tr").click(function() {
	        var id = $(this).find('td:eq(0)').text();
			$("[name='consignmentId']").val(id);
		});

	});


</script>

@endsection