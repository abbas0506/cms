@extends ('admin-base')
@section('nav')
<section id='nav-section'>
   <div class="container mt-4">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('admin-home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Consignees</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-3 offset-col-5 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
            	<a href="{{route('consignees.create')}}">
                  <div class="icon-xl text-success"><i class="fa fa-plus-circle"></i></div>
                  <div class="micro">New Consignee</div>
               </a>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection

@section('search')
<section id='nav-section'>
	<div class='container'>
		<div class="row justify-content-center">
			<div class='col-sm-8'>
				<div class='row form-group'>
					<div class="col-sm-3 my-auto">
						<i class="fas fa-search text-secondary icon-l"></i>
						<input type="text" id="filter" class="form-control text-center round" placeholder="Type name">
					</div>
				</div>
			</div>
		</div>
	</div> 
</section>
@endsection

@section('data')
<section id='nav-section'>
	<div class='container'>
		<div class="row justify-content-center">
			<div class='col-sm-8'>
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
							<td>ID</td>
							<td>Name</td>
							<td>Phone</td>
							<td>Email</td>
							<td>Address</td>
							<td class="text-center"><i class="fa fa-bars"></td>
						</tr>
					</thead>
					<tbody>
						@foreach($consignees as $consignee)
						<tr>
								<td >{{$consignee->id}}</td>
								<td>{{$consignee->name}}</td>
								<td>{{$consignee->phone}}</td>
								<td>{{$consignee->email}}</td>
								<td>{{$consignee->address}}</td>
								
								<form action="{{ route('consignees.destroy', $consignee->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
									<td class='text-center'>
										<a href="{{ route('consignees.edit', $consignee->id)}}" class='btn btn-sm btn-link text-success'><i class="fas fa-pen"></i></a>
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
</section>		
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$("#filter").on("keyup", function() {
	      	var txt = $(this).val().toLowerCase();
	      	$("table tbody tr").each(function() {
	        	if($(this).children().eq(1).text().toLowerCase().includes(txt))
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