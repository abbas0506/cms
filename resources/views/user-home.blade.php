@extends ('user-base')
<style>
   p{ margin-bottom: 0px !important;}
</style>

@section('page-data-section')
<section id="page-data-section">
   <div class="container">
      <div class="row no-gutters justify-content-center">
               <div class="col-sm-8 mt-5">
                  <a href="{{route('containers.index')}}" class="shortcut">   
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-success txt-lb'><i class='fa fa-truck'></i></div>
                        <div class='col-sm-11'>
                           <h4>Containers</h4>
                           <p>Here you can add new container and feed its consignments</p>
                        </div>
                    
                     </div>
                  </a>
                  <a href="{{route('consignments.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 teal txt-lb'><i class='fa fa-box'></i></div>
                        <div class='col-sm-11'>
                           <h4>Consignments</h4>
                           <p>All consignments are available here. Use this option to find any consigment randomly</p>
                        </div>
                     </div>
                  </a>
                  <a href="{{route('batches.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-danger txt-lb'><i class='fa fa-rupee-sign'></i></div>
                        <div class='col-sm-11'>
                           <h4>Recovery</h4>
                           <p>Here you can feed new recovery in batches.</p>
                        </div>
                        
                     </div>
                  </a>
                  <a href="{{route('recoveries.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-success txt-lb'><i class='fa fa-user'></i></div>
                        <div class='col-sm-11'>
                           <h4>Consignee Accounts</h4>
                           <p>Here you can see details of consignee's accounts</p>
                        </div>
                        
                     </div>
                  </a>
                  <a href="{{route('changePassword')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-primary txt-lb'><i class='fa fa-key'></i></div>
                        <div class='col-sm-11'>
                           <h4>Change Password</h4>
                           <p>Here you can change your password. Try to use complex password</p>
                        </div>
                     </div>
                  </a>
               </div>   
         </div>
         
   </div>
</section>
@endsection

