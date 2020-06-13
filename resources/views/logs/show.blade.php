@extends ('user-base')
@section('page-title','Container Info.')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type bilty no. or consignee">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
		
	<a href="{{ url('consignments_create', $container->id)}}"><i class="fas fa-paperclip ml-3"></i></a>
	<a target='_blank' href="#"><i class="fa fa-print ml-3"></i></a>
		 
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
			<div class="row no-gutters">
				<div class="col-sm-8 pr-4">
											
						<div class="row no-gutters">
							<div class="col-sm-3 strong">Vehichle No : </div>
							<div class="col-sm-9">{{$container->vehicleNo}}</div>
						</div>
						<div class="row no-gutters ">
							<div class="col-sm-3 strong">Carrier Name : </div>
							<div class="col-sm-9">{{$container->carrierName}} , {{$container->carrierPhone}}</div>
						</div>
						<div class="row no-gutters">
							<div class="col-sm-3 strong">Date & Time : </div>
							<div class="col-sm-9">{{$container->arrivalDate}} , {{$container->arrivalTime}}</div>
						</div>
										
				</div>
				<div class="col-sm-2 pr-4">
					<div class="row no-gutters">
						<div class="col-sm-6 strong">Total</div>
						<div class="col-sm-6 ">{{$payable}}</div>
					</div>
					<div class="row no-gutters">
						<div class="col-sm-6 strong">Paid</div>
						<div class="col-sm-6 ">{{$paid}}</div>
					</div>
					<div class="row no-gutters border-top mt-2">
						<div class="col-sm-6 strong">Arears</div>
						<div class="col-sm-6 ">{{$payable-$paid}}</div>
					</div>
					
				</div>
				
				<div class="col-sm-2">
					<form method="post" action="{{ route('containerPayment.store') }}">
        				@csrf
						<div>
							<input type="text" name="containerId" value="{{$container->id}}" hidden>
							<input type="text" class="form-control text-center" name="paidAmount" placeholder="arears" value='{{$payable-$paid}}' @if($paid >= $payable )
								disabled 
							@endif
							>
						</div>
						<div class="text-right">
							<button class="btn btn-success btn-sm btn-block mt-2" @if($paid >=$payable)
								disabled 
							@endif
							>Pay &nbsp <i class="fas fa-hand-holding-usd"></i></button>
						
						</div>
					</form>

					
					
				</div>
				
			</div>
		</div>

		<table class="table table-striped">
		    <thead>
		        <tr class="txt-mb">
		          <td>Bilty No.</td>
		          <td>Consigner</td>
		          <td>Consignee</td>
		          <td>Description</td>
		          <td>Charges</td>
		          <td>Status</td>
		          		          
		          <td class="text-center"><i class="fas fa-caret-down"></i></td>
		        </tr>
		    </thead>
		    <tbody>
		        @foreach($consignments as $consignment)
		        <tr>
		            <td>{{$consignment->biltyNo}}</td>
		            <td>{{$consignment->consigner}}</td>
		            <td>{{$consignment->consignee}}</td>
		            <td>{{$consignment->description}}</td>
		            <td>{{$consignment->charges}}</td>
		            <td>
		            	@if($consignment->status=='Pending')
		            		<i class="fas fa-circle micro red pr-1"></i>
		            	@else
		            		<i class="fas fa-circle micro green pr-1"></i>
		            	@endif
		            	<a href="{{ route('consignments.show', $consignment->id)}}">{{$consignment->status}}</a>
		            </td>
		            
		            <td class="txt-s text-center">
		               <a href="{{ route('consignments.edit', $consignment->id)}}"><i class="fa fa-cog txt-teal pt-2"></i></a>
		            </td>
				</tr>
		        @endforeach
		    </tbody>
		  </table>
		
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
	 
	 $(window).scroll(function(){

	 	if (window.pageYOffset >= sticky) {
		    $('#stickyheader').addClass("sticky")
		  } else {
		    $('#stickyheader').removeClass("sticky");
		  }

	 });

	
	});


</script>

@endsection