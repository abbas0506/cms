
@extends ('user-base')

@section('page-title')
    Consignment : {{ $consignment->biltyNo }}
@endsection

@section('searchbar')
    @parent
@endsection

@section('toolbar')
  
    <a href="#"><i class="fa fa-print pl-3"></i></a> 
     
@endsection

@section('page')
    
    <div class="container shadow-lg p-5 mt-4">
        @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
    @endif

    <div class="row no-gutters">
        <div class="col-sm-7">
            <div class="row no-gutters strong txt-lb">
                <div class="col-sm-6">Status:</div>
                <div class="col-sm-6 ">
                @if($consignment->getStatus()=='Pending')
                    <span class="red"> Pending</span>
                @else
                    <span class="green"> Delivered</span>
                @endif
            </div>
        </div>
        <br>
        <div class="row no-gutters">
            <div class="col-sm-6 strong">Consigner:</div>
            <div class="col-sm-6 ">{{$consignment->consigner->name}}</div>
        </div>
        <div class="row no-gutters">
            <div class="col-sm-6 strong">Consignee:</div>
            <div class="col-sm-6 ">{{$consignment->consignee->name}}</div>
        </div>
        <div class="row no-gutters">
            <div class="col-sm-6 strong">Description:</div>
            <div class="col-sm-6 ">{{$consignment->description}}</div>
        </div>
                            
        <div class="row no-gutters border-bottom mt-4 strong teal w-75">Receiving Detail</div>

        @if($consignment->getStatus()=='Delivered')
                                
            <div class="row no-gutters mt-4">
                <div class="col-sm-6 strong">Receiver Name:</div>
                <div class="col-sm-6 ">{{$consignment->receiverName}}</div>
            </div>
            <div class="row no-gutters">
                <div class="col-sm-6 strong">Receive Date:</div>
                <div class="col-sm-6 ">{{$consignment->created_at}}</div>
            </div>
            <div class="row no-gutters w-75">
                <div class="col my-auto">
                    <center>
                    @if($consignment->receiverPic)
                        <img src="{{asset('uploads')}}/{{$consignment->receiverPic}}" width='120' height="120" class="rounded-circle">
                    @else
                        <div  class="rounded-circle" style="width: 120px; height: 120px; background-color:#F6D5C2; padding-top: 40px">No image</div>

                    @endif
                    </center>
                                    
                </div>
            </div>
        @endif
                                
    </div>
                        
                        <div class="col-sm-4 offset-sm-1">
                            <div class="row no-gutters border-bottom mb-2 strong teal">
                                Charges Detail
                            </div>
                            
                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Vehicle Charges:</div>
                                <div class="col-sm-6 text-right">{{$consignment->vehicleCharges}}</div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Loading-1:</div>
                                <div class="col-sm-6 text-right">{{$consignment->loadOneCharges}}</div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Bilty-1:</div>
                                <div class="col-sm-6 text-right">{{$consignment->biltyOneCharges}}</div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Insurance:</div>
                                <div class="col-sm-6 text-right">{{$consignment->insurance}}</div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Cart-1:</div>
                                <div class="col-sm-6 text-right">{{$consignment->cartOneCharges}}</div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Others:</div>
                                <div class="col-sm-6 text-right">{{$consignment->otherCharges}}</div>
                            </div>

                            <div class="row no-gutters border-top brown">
                                <div class="col-sm-5 offset-sm-1 strong">Subtotal-1:</div>
                                <div class="col-sm-6 text-right">
                                    
                                    {{$consignment->getSubTotalOne()}}

                                </div>
                            </div>
                            
                            <div class="row no-gutters mt-4">
                                <div class="col-sm-5 offset-sm-1 strong">Bilty-2:</div>
                                <div class="col-sm-6 text-right">{{$consignment->biltyTwoCharges}}</div>
                            </div>
                            
                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Cart-2:</div>
                                <div class="col-sm-6 text-right">{{$consignment->cartTwoCharges}}</div>
                            </div>
                            
                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Unloading:</div>
                                <div class="col-sm-6 text-right">{{$consignment->unloadCharges}}</div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-sm-5 offset-sm-1 strong">Loading-2:</div>
                                <div class="col-sm-6 text-right">{{$consignment->loadTwoCharges}}</div>
                            </div>
                            
                            <div class="row no-gutters border-top brown">
                                <div class="col-sm-5 offset-sm-1 strong">Subtotal-2:</div>
                                <div class="col-sm-6 text-right">
                                    
                                    {{$consignment->getSubTotalTwo()}}
                                </div>
                            </div>
                            <div class="row no-gutters red mt-4 border-top">
                                <div class="col-sm-5 offset-sm-1 strong">Grand Total:</div>
                                <div class="col-sm-6 strong text-right">{{$consignment->getSubTotalOne()+$consignment->getSubTotalTwo()}}</div>
                            </div>
                            
                        </div>
                      
                    </div>
        </div>
	
              
    
@endsection


