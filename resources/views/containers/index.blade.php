@extends ('user-base')

@section('page-title-section')
<section class='page-title-section'>
   <div class="container">
      <div class="row no-gutters my-auto">
         <div class="col-md-4 mr-auto">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('user-home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Containers</li>
               </ol>
           </nav>
         </div>
      <div class="col-md-3 offset-col-5 text-center">
         <div class="row no-gutters">
            <div class="col text-center">
            <a href="{{route('containers.create')}}">
                  <div class="icon-xl text-success"><i class="fa fa-plus-circle"></i></div>
                  <div class="micro">New Container</div>
               </a>
            </div>
            <div class="col text-center">
               <a href="">
                  	<div class="icon-xl text-success"><i class="fa fa-truck"></i></div>
                  	<div class="micro">
                  	@if($mode==10)
						<a href="{{url('containers_switch_show_mode', '*')}}">View All</a>
					@else
						
						<a href="{{url('containers_switch_show_mode', 10)}}">Most Recent</a>
					@endif
              	</div>
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
					          <td>Vehicle No</td>
					          <td>Forwarder</td>
					          <td class="text-right">Consignments</td>
							  <td class="text-right">Gross</td>
							  <td class="text-right">Delivery</td>
							  <td class="text-right">Net</td>
					         <td class="text-center"><i class="fas fa-bars"></td>
					        </tr>
					    </thead>
					    <tbody>
					        @foreach($containers as $container)
					        <tr>
					            <td>{{$container->created_at->toDateString()}}</td>
					            <td>{{$container->vehicleNo}}</td>
					            <td>{{$container->forwarder->name}}</td>
								<td class="text-right">{{$container->consignments->count()}}</td>
								<td class='text-right'>{{$container->getSubTotalOne()}}</td>
								<td class='text-right'>{{$container->getSubTotalOne()*0.05}}</td>
								<td class='text-right'>{{$container->getSubTotalOne()*0.95}}</td>
					         <form action="{{ route('containers.destroy', $container->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="p-0 m-0">
									<td class='text-center'>
										<a href="{{ route('containers.show', $container->id)}}" class='btn btn-sm btn-link text-info'><b><i class="fa fa-eye"></b></i></a>
										<a href="{{ route('containers.edit', $container->id)}}" class='btn btn-sm btn-link text-success'><i class="fas fa-pen"></i></a>
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
					||$(this).children().eq(2).text().toLowerCase().includes(txt)
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