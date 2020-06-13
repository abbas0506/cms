@extends ('admin-base')
@section('page-title','Consigners')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type here">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
	<a href="{{route('consigners.create')}}"><i class="fa fa-plus"></i></a> 
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
		          <td>ID</td>
		          <td>Name</td>
		          <td>Phone</td>
		          <td>Email</td>
		          <td>Address</td>
		          <td colspan = 2 class="text-center"><i class="fas fa-caret-down"></td>
		        </tr>
		    </thead>
		    <tbody>
		        @foreach($consigners as $consigner)
		        <tr style='height:50px'>
		            <td >{{$consigner->id}}</td>
		            <td>{{$consigner->name}}</td>
		            <td>{{$consigner->phone}}</td>
		            <td>{{$consigner->email}}</td>
		            <td>{{$consigner->address}}</td>
		            <td class="txt-s text-center">
		               <a href="{{ route('consigners.edit', $consigner->id)}}"><i class="fa fa-pencil-alt text-success pt-2"></i></a>
		            </td>
		            <td class="text-center txt-s">
		                <form class='delete' action="{{ route('consigners.destroy', $consigner->id)}}" method="post" onsubmit="return confirm('Are you sure?')">
		                  @csrf
		                  @method('DELETE')
		                  <button class="btn btn-link" type="submit"><i class="fa fa-times text-danger"></i></button>
		                </form>
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
	      	$("table tr").each(function() {
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