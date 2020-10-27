@extends ('user-base')
@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Recovery Batches</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-3 offset-col-5 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
            <a href="{{route('batches.create')}}">
                  <div class="icon-xl text-success"><i class="fa fa-plus-circle"></i></div>
                  <div class="micro">New Batch</div>
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
									<td>Date</td>
									<td class="text-right">Batch ID</td>
									<td class="text-right">No. of Rec.</td>
									<td class="text-right">Amount</td>
									<td class="text-center"><i class="fas fa-bars"></td>
								</tr>
							</thead>
							<tbody>
								@foreach($batches as $batch)
								<tr>
									<td>{{$batch->created_at->format('d/m/Y')}}</td>
									<td class="text-right">{{$batch->id}}</td>
									<td class="text-right">{{$batch->recoveries->count()}}</td>
									<td class="text-right">{{$batch->getTotal()}}</td>
										
									<form action="{{ route('batches.destroy', $batch->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
										<td class='text-center'>
											<a href="{{route('batches.show', $batch->id)}}" class='btn btn-sm btn-link text-info'><i class="far fa-eye"></i></a>
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