@extends ('admin-base')
@section('page-title','Users')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type here">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
	<a href="{{route('users.create')}}"><i class="fa fa-plus"></i></a> 
	<a target='_blank' href="#"><i class="fa fa-print pl-3"></i></a>
	 
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
		          <td>User</td>
		          <td>Status</td>
		          <th><center>&#11167;</center></th>
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
		            		<button type="submit" class="btn btn-link"> 
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
		                  <button class="btn btn-link" type="submit"><i class="fa fa-trash-alt text-danger"></i></button>
		                </form>
		            </td>
		        </tr>
		        @endforeach
		    </tbody>
		  </table>
		
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