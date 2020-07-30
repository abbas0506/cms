@extends ('user-base')
@section('page-title')
	Recoveries
@endsection

@section('toolbar')
	<a href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#createPayment"><i class="fa fa-plus"></i></a>
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
			<div class="col-sm-3 p-3 my-bg-warning text-center teal">
				<div class="strong mb-2"><i class="far fa-user"></i></div>
				<div>{{$consignee->name}}</div>					
			</div>
			<div class="col-sm-3 p-3 my-bg-success text-center text-success">
				<div class="strong ">Total</div>
				<div>{{$consignee->sumOfCr()}}</div>					
			</div>
			<div class="col-sm-3 p-3 my-bg-info text-center text-primary">
				<div class="strong">Recovery</div>
				<div>{{$consignee->sumOfDb()}}</div>					
			</div>
			<div class="col-sm-3 p-3 my-bg-warning text-center text-danger">
				<div class="strong">Arears</div>
				<div>{{$consignee->sumOfCr()-$consignee->sumOfDb()}}</div>					
			</div>
		</div>
	</div>			
		
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class='nav-link active' data-toggle="tab" href="#recentTransactions">Recent Transacton</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' data-toggle="tab" href="#recoveries">Recoveries Only</a>
		</li>
		<li class='nav-item'>
			<a class='nav-link' data-toggle="tab" href="#consignments">Consignments Only</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane container active" id="recentTransactions">
			@php
				$sr=0;
				$crnt=$consignee->sumOfCr()-$consignee->sumOfDb(); 
				$prev=0;		//previous
			@endphp

			<table class="table table-striped">
				<thead>
					<tr class="strong">
						<td>Sr</td>
						<td>Date</td>
						<td>Description</td>
						<td>DB</td>
						<td>CR</td>
						<td>Net</i></td>
					</tr>
				</thead>
				<tbody>
					@foreach($mixedTransactions as $transaction)
					<tr>
						<td>{{++$sr}}</td>
						<td>{{$transaction->created_at}}</td>
						<td>{{$transaction->description}}</td>
						@if($transaction->tx==='cr')
							<td>{{$transaction->amount}}</td>
							<td>-</td>
							
							@php
								$crnt+= $prev;
							@endphp
							<td>{{$crnt}}</td>
							@php
								$prev = -1*$transaction->amount;
							@endphp
						@else
							<td>-</td>
							<td>{{$transaction->amount}}</td>
							@php
								$crnt+= $prev;
							@endphp
							<td>{{$crnt}}</td>
							@php
								$prev = $transaction->amount;
							@endphp
							
						@endif
						
					</tr>
					@endforeach

					<tr>
						<td colspan=6 class="text-center strong text-primary">Opening Balance: &nbsp {{$crnt+$prev}}</td>
					</tr>
				</tbody>
			</table>

		</div>
		<div class="tab-pane container" id="recoveries">
			@php
				$sr=0
			@endphp

			<table class="table table-striped">
				<thead>
					<tr class="strong border-0">
						<td>Sr</td>
						<td>Date</td>
						<td>Description</td>
						<td>Amount</td>
						<td class="text-center"><i class="fas fa-bars"></i></td>
					</tr>
				</thead>
				<tbody>
					@foreach($consignee->recoveries as $recovery)
					<tr>
						<td>{{++$sr}}</td>
						<td>{{$recovery->created_at}}</td>
						<td>{{$recovery->description}}</td>
						<td>{{$recovery->amount}}</td>
						<form action="{{ route('recoveries.destroy', $recovery->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
							<td class='text-center'>
								<a href="{{route('recoveries.edit',$recovery->id)}}" class='btn btn-sm btn-link text-primary'><i class="fas fa-pencil-alt"></i></a>
								@csrf
								@method('DELETE')
								<button class="btn btn-sm btn-link text-danger btn-sm" type="submit"><i class="far fa-trash-alt"></i></button>
							</td>
						</form>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
		
		<div id="consignments" class="tab-pane fade in active">
			@php
			$sr=0
			@endphp	
				   
			<table class="table table-striped">
				<thead>
					<tr class="strong">
						<td>Sr</td>
						<td>Date</td>
						<td>Bilty No.</td>
						<td>Description</td>
						<td>Delivery</td>
						<td>Amount</td>
						<td class="text-center"><i class="fas fa-bars"></i></td>
					</tr>
				</thead>
				<tbody>
					@foreach($consignee->consignments as $consignment)
					<tr>
						<td>{{++$sr}}</td>
						<td>{{$consignment->created_at}}</td>
						<td>{{$consignment->biltyNo}}</td>
						<td>{{$consignment->description}}</td>
						<td>
							@if($consignment->getStatus()=='Pending')
								<i class="fas fa-circle micro red pr-1"></i>
								Pending
							@else
								<i class="fas fa-check green"></i>
							@endif
							<a href="{{ route('consignments.show', $consignment->id)}}">{{$consignment->status}}</a>
						</td>
						<td>{{$consignment->getTotal()}}</td>
						<form action="{{ route('consignments.destroy', $consignment->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
							<td class='text-center'>
								<a href="{{ route('consignments.edit', $consignment->id)}}" class='btn btn-sm btn-link text-primary btn-sm'><i class="fas fa-pencil-alt"></i></a>
								@csrf
								@method('DELETE')
								<button class="btn btn-sm btn-link text-danger btn-sm" type="submit"><i class="far fa-trash-alt"></i></button>
							</td>
						</form>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
				
	</div>
	<!----------------------------------------------------------------------------
									Create Payment modal
	------------------------------------------------------------------------------>

	<!-- Insert class Modal -->
	<div class="modal fade" id="createPayment" role="dialog" >
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
					<form  method="post" action="{{route('recoveries.store')}}">
					@csrf
						<div class="row no-gutters form-group">    
							<input type="text" name='consigneeId' value='{{$consignee->id}}' hidden >  
							<div class="col-sm-2 pr-2">
							<label for="amount">Amount *</label>
							<input type="text" class="form-control" name="amount" autocomplete='off' pattern='[0-9]{1,5}([.][0-9]{1,5}){0,1}' placeholder="amount" required>

							</div>
							<div class="col-sm-10 ">
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

@section('delfrm')

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