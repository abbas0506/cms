@extends ('user-base')
@section('page-data-section')
<section class="page-data-section">
   <div class="container">
      <div class="row no-gutters">
         <div class="col">
            <div class="row no-gutters justify-content-center">
               <div class="col-sm-8 mt-5">
                  <div class="bg-light p-4 border rounded form-group">
                     <h4>Containers</h4>
                     <p>Containers are vehicles that carry consignments/bilties to your office. You need to provide container's basic info  like vehicle No, carrier name etc. before you feed the details of any consignment.</p>
                     <p class="text-right m-0"><a href="{{route('containers.index')}}">Go</a></p>

                  </div>
                  <div class="bg-light p-4 border rounded form-group"><h4>Recovery</h4>
                     <p>Recovery is the amount paid by consignee as service charges/other. You need to pick a consignee from recovery list and feed recovered amount</p>
                     <p class="text-right m-0"><a href="{{route('recoveries.index')}}">Go</a></p>
                  </div>
                  
               </div>   
            </div>
         </div>
      </div>
   </div>
</section>
@endsection