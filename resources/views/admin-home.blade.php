@extends ('admin-base')
<style>
   p{ margin-bottom: 0px !important;}
</style>

@section('data')
<section id="page-data-section">
   <div class="container">
      <div class="row no-gutters justify-content-center">
               <div class="col-sm-8 mt-5">
                  <a href="{{route('users.index')}}" class="shortcut">   
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-success txt-lb'><i class='far fa-user'></i></div>
                        <div class='col-sm-11'>
                           <h4>Users</h4>
                           <p>Here you can add new user and manage existing users. User status can be changed from active to blocked and vice versa. Once deleted, can not be undone.</p>
                        </div>
                     </div>
                  </a>
                  <a href="{{route('forwarders.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-danger txt-lb'><i class='far fa-user'></i></div>
                        <div class='col-sm-11'>
                           <h4>Forwarders</h4>
                           <p>Forwarder is a person that forwards consignments and usually owns carrying vehicle. Remember, forwarders delete operation can cause major loss of concerned data.</p>
                        </div>
                     </div>
                  </a>
                  <a href="{{route('consigners.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-primary txt-lb'><i class='far fa-user'></i></div>
                        <div class='col-sm-11'>
                           <h4>Consigners</h4>
                           <p>Consigner is actual source of consignment i.e consignment sender. Here you can manage existing consigners. Delete operation will cause permanant loss of data</p>
                        </div>
                     </div>
                  </a>
                  <a href="{{route('consignees.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 text-info txt-lb'><i class='far fa-user'></i></div>
                        <div class='col-sm-11'>
                           <h4>Consignees</h4>
                           <p>Consigner is a person that receives consignment i.e consignment receiver. Here you can manage existing consignees. Delete operation will cause permanant loss of data</p>
                        </div>
                     </div>
                  </a>
                  <a href="{{route('logs.index')}}" class="shortcut">
                     <div class="row border rounded form-group p-3">
                        <div class='col-sm-1 teal txt-lb'><i class='far fa-bookmark'></i></div>
                        <div class='col-sm-11'>
                           <h4>Log</h4>
                           <p>Here you can see all activities performed from user side. </p>

                        </div>                        
                     </div>
                  </a>
               </div>   
            </div>
         
   </div>
</section>
@endsection