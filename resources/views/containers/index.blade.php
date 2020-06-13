@extends ('user-base')
@section('page-title','Containers')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type date or vehichle no.">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
	<a href="{{route('containers.create')}}" class='btn btn-success btn-sm'><i class="fa fa-plus"></i></a>
	<span class="text-primary pl-2"> <i class="fab fa-searchengin"></i>	
		@if($mode==5)
			
			<a href="{{url('containers_switch_show_mode', '*')}}">Show All</a>
		@else
			
			<a href="{{url('containers_switch_show_mode', 5)}}">Top 5</a>
		@endif
	</span>
		
	 
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

		<table class="table table-striped">
		    <thead>
		        <tr class="txt-mb">
		          <td>Date</td>
		          <td>Vehicle No</td>
		          <td>Carrier</td>
		          <td class="text-right">Consignments</td>
				  <td class="text-right">Amount</td>
		         <td class="text-center"><i class="fas fa-cogs"></td>
		        </tr>
		    </thead>
		    <tbody>
		        @foreach($containers as $container)
		        <tr>
		            <td>{{$container->created_at->toDateString()}}</td>
		            <td>{{$container->vehicleNo}}</td>
		            <td>{{$container->carrierName}}</td>
					<td class="text-right">{{$container->consignments->count()}}</td>
					<td class='text-right'>{{$container->getTotal()}}</td>
		            <form action="{{ route('containers.destroy', $container->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
					<td class='text-center'>
						<a href="{{ route('containers.show', $container->id)}}" class='btn btn-sm btn-info'><i class="far fa-eye"></i></a>
						<a href="{{ route('containers.edit', $container->id)}}" class='btn btn-sm btn-primary'><i class="fas fa-pencil-alt"></i></a>
		            	@csrf
						@method('DELETE')
						<button class="btn btn-sm btn-danger" type="submit"><i class="far fa-trash-alt"></i></button>
						
					</td>
					</form> 
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
	        	
	        	if($(this).children().eq(0).text().toLowerCase().includes(txt)
	        		||$(this).children().eq(1).text().toLowerCase().includes(txt)
	        		)
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

	$('[data-toggle="tooltip"]').tooltip();
	});


</script>

@endsection