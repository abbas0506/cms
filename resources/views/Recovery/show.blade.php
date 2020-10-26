@extends ('user-base')
@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{route('recoveries.index')}}">Recovery List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$consignee->name}}</li>
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
         $sr=1;
      @endphp
      <div class="row no-gutters">
         <div class="col">
            <div class="row no-gutters ml-3 teal ">
               	<div class="col-sm-2 txt-lb" data-toggle="collapse" data-target="#containerInfo">
               		<i class="far fa-user pr-2"></i>{{$consignee->name}} <i class="fas fa-chevron-down pl-5"></i>
               	</div>
            </div>
            
            <div class="row no-gutters justify-content-center">
               <div class="col-sm-9">
						<div class='row no-gutters txt-s mt-2 form-group collapse' id='containerInfo'> 
               		<div class="col p-4 border rounded">
							<div class="row no-gutters ">
               			<div class="col-sm-2 strong"> Total : </div> 
               			<div>{{$consignee->sumOfCr()}}</div>
               		</div>
               		<div class="row no-gutters">
               			<div class="col-sm-2 strong">Recovered : </div>
               			<div>{{$consignee->sumOfDb()}}</div>
               		</div>
               		<div class="row no-gutters">
               			<div class="col-sm-2 strong"> Net Arrears : </div>
               			<div>{{$consignee->sumOfCr()-$consignee->sumOfDb()}}</div>
               		</div>
							</div>
               	</div>

					<!-- navigation tabs -->

					<ul class="nav nav-tabs mt-4 mb-4">
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


					<!-- Recent transactions Tab -->
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
						<td>{{$transaction->created_at->format('d/m/Y')}}</td>
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
		
		<!-- recoveries tab -->
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
						<td>{{$recovery->created_at->format('d/m/Y')}}</td>
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

		<!-- consignments tab -->
		
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
						<td>Items</td>
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
						<td>{{$consignment->created_at->format('d/m/Y')}}</td>
						<td>{{$consignment->biltyNo}}</td>
						<td>{{$consignment->nItems}}</td>
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
            </div>
         </div>
      </div>
   </div>
</section>
@endsection

@section('modal-section')
	<!----------------------------------------------------------------------------
									Create Payment modal
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