@extends ('admin-base')
@section('nav')
<section id='nav-section'>
   <div class="container mt-4">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('admin-home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Users</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-3 offset-col-5 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
            	<a href="{{route('users.create')}}">
                  <div class="icon-xl text-success"><i class="fa fa-plus-circle"></i></div>
                  <div class="micro">New User</div>
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
						<input type="text" id="filter" class="form-control text-center round" placeholder="Type here">
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
							<td>User</td>
							<td>Status</td>
							<th class="text-center"><i class="fa fa-bars"></i></th>
							</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
						<tr>
								<td style="width:80%">{{$user->id}}</td>
								<td class="txt-l">
									<form class='delete p-0 m-0' action="{{ route('users.update', $user->id)}}" method="post" onsubmit="return confirm('Are you sure?')">
									@csrf
									@method('PUT')
										<input type='text' value="{{$user->status}}" name='status' hidden>
										<button type="submit" class="btn btn-sm btn-link"> 
											@if($user->status==0)	
												<i class='fas fa-toggle-off'></i>
											@else
												<i class='fas fa-toggle-on'></i>
											@endif
										</button> 
										
									</form>
								</td>
								<td class="text-center txt-s">
									<form class='delete p-0 m-0' action="{{ route('users.destroy', $user->id)}}" method="post" onsubmit="return confirm('Are you sure?')">
										@csrf
										@method('DELETE')
										<button class="btn btn-link btn-sm" type="submit"><i class="fa fa-trash-alt text-danger"></i></button>
									</form>
								</td>
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
	        	if($(this).children().eq(0).text().toLowerCase().includes(txt))
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