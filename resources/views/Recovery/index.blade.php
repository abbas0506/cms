@extends ('user-base')
@section('page-title','Recoveries')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type consignee name">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
	<a href="{{route('containers.create')}}" class='btn btn-primary btn-sm'><i class="fa fa-print"></i></a>
		 
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
		        <tr class="strong">
		          <td>Consignee</td>
		          <td>Phone</td>
		          <td>Total</td>
		          <td>Recovered</td>
		          <td>Due</td>
		          <td class="text-center"><i class="fas fa-bars"></td>
		        </tr>
		    </thead>
		    <tbody>
		        @foreach($consignees as $consignee)
		        <tr>
		            <td>{{$consignee->name}}</td>
		            <td>{{$consignee->phone}}</td>
		            <td>{{$consignee->sumOfCr()}}</td>
		            <td>{{$consignee->sumOfDb()}}</td>
		            <td>{{$consignee->sumOfCr()-$consignee->sumOfDb()}}</td>
		            
					<td class='text-center'>
						<a href="{{route('recoveries.show', $consignee->id)}}" class='btn btn-sm btn-link text-info'><i class="far fa-eye"></i></a>
						<a href="#" class='btn btn-sm btn-link text-danger'><i class="fas fa-history"></i></a>
		            	
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