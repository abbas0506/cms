@extends ('user-base')
@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-6 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Accounts List</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-2 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
            	<a href="{{route('containers.create')}}">
                  <div class="icon-xl text-success"><i class="fa fa-print"></i></div>
                  <div class="micro">Print Account Summary</div>
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
      @elseif(session('success'))
      <script type="text/javascript">
	      Swal.fire({
	          icon: 'success',
	          text: "{{session('success')}}",
	          showConfirmButton: false,
	          timer:2000
	        });
      	</script>
    
      @endif
      @php
         $sr=1;
      @endphp
      <div class="row no-gutters">
         <div class="col">
            <div class="row no-gutters justify-content-center">
               <div class="col-sm-8">
					<div class="row">
					 	<div class="col-sm-4 my-auto">
					 		<i class="fas fa-search text-secondary icon-l"></i>
					 		<input type="text" id="filter" class="form-control text-center round" placeholder="Search here">
					 	</div>
					 
					</div>

					<table class="table table-striped mt-2">
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
								</td>
								
							</tr>
							@endforeach
						</tbody>
					</table>
					</div>   
            </div>
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