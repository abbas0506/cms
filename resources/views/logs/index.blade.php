@extends ('admin-base')
@section('page-title','Log')
@section('searchbar')
	 <div class="row">
	 	<div class="col-sm-6 my-auto">
	 		<i class="fas fa-search text-secondary icon-l"></i>
	 		<input type="text" id="filter" class="form-control text-center round" placeholder="Type operation code">
	 	</div>
	 
	</div>
@endsection

@section('toolbar')
		 
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
		          <td>Time Stamp</td>
		          <td>Operation</td>
		          <td>Description</td>
		          </tr>
		    </thead>
		    <tbody class="txt-s">
		        @foreach($logs as $log)
		        <tr>
		            <td>{{$log->created_at}}</td>
		            <td>{{$log->operation}}</td>
		            <td>{{$log->description}}</td>
		            	            		            
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

	$('[data-toggle="tooltip"]').tooltip();
	});


</script>

@endsection