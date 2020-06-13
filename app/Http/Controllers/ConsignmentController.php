<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\uploadedFile;
use App\Consignment;
use App\Container;
use App\Consigner;
use App\Consignee;
use App\Log;

use Illuminate\Support\Carbon;

class ConsignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        //
        $consignments=Consignment::all()->sortByDesc('created_at');
        return view('consignments.index',compact('consignments'));
                
    }

    public function create($id)
    {
        //
        $container=Container::findOrFail($id);
        $consigners=Consigner::select('id','name')->get();
        $consignees=Consignee::select('id','name')->get();

        return view('consignments.create',compact('container','consigners','consignees'));

    }

    
    public function store(Request $request)
    {
        //
        $request->validate([
            'containerId'=>'required',
            'biltyNo' => 'required',
            'consignerId' => 'required',
            'consigneeId' => 'required',
            'nItems' => 'required',
            'vehicleCharges' => 'required',
            'biltyOneCharges' => 'required',
            'biltyTwoCharges' => 'required',
            'insurance' => 'required',
            'cartOneCharges' => 'required',
            'cartTwoCharges' => 'required',
            'loadOneCharges' => 'required',  
            'unloadCharges' => 'required',      
        ]);

        $consignment=new Consignment([
            'biltyNo'   => $request->biltyNo,
            'containerId' => $request->containerId,
            'consignerId' => $request->consignerId,
            'consigneeId' => $request->consigneeId,
            'nItems' => $request->nItems,
            'description' => $request->description,
            'vehicleCharges' => $request->vehicleCharges,
            'loadOneCharges' => $request->loadOneCharges,
            'biltyOneCharges'=>$request->biltyOneCharges,
            'insurance' => $request->insurance,
            'cartOneCharges' => $request->cartOneCharges,
            'otherCharges' => $request->otherCharges,
                        
            'unloadCharges' => $request->unloadCharges,
            'biltyTwoCharges'=>$request->biltyTwoCharges,
            'cartTwoCharges' => $request->cartTwoCharges,
            'loadTwoCharges' => $request->loadTwoCharges,
                    
        ]);
        
  
        $consignment->save();

        //create log
        $log= new Log();
        $log->operation="ADD";
        $log->description="Consignment was added: Bilty No.".$consignment->biltyNo.", items: ".$consignment->nItems;

        $log->save();
        return redirect ('containers/'.$request->containerId);
       
    }

    public function handover(Request $request)
    {
        //
        $request->validate([

            'receiverName' => 'required',
            'receiverPic' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        
        ]);
        $consignment=Consignment::findOrFail($request->consignmentId);
        $consignment->receiverName=$request->receiverName;

        if($consignment->receiverName==''){
            $consignment->receiverPic=null;
            
        }
        else if($request->receiverPic!=''){
            
            $imageName = time().'.'.$request->receiverPic->extension();  
            $request->receiverPic->move(public_path('uploads'), $imageName);

            $consignment->receiverPic=$imageName;
        }

        $consignment->save();

        //create log
        $log= new Log();
        $log->operation="HND";
        $log->description="Consignment No.:".$consignment->biltyNo.", handed over to: ".$consignment->receiverName;
        
        $log->save();

        return redirect ('containers/'.$consignment->container->id);
        
       
    }
        
    public function show($id)
    {
        $consignment=Consignment::findOrFail($id);
        return view('consignments.show', compact('consignment'));
    }

    
    public function edit($id)
    {
        //
        $consignment=Consignment::find($id);
        $consigners=Consigner::select('id','name')->get();
        $consignees=Consignee::select('id','name')->get();

        return view('consignments.edit', compact('consignment','consigners','consignees'));
        
    }

    public function update(Request $request, $id)
    {
        //
        $consignment=Consignment::find($id);
                
        $request->validate([
            'consignerId' => 'required',
            'consigneeId' => 'required',
            'nItems' => 'required',
            'vehicleCharges' => 'required',
            'biltyOneCharges' => 'required',
            'biltyTwoCharges' => 'required',
            'insurance' => 'required',
            'cartOneCharges' => 'required',
            'cartTwoCharges' => 'required',
            'loadOneCharges' => 'required',  
            'unloadCharges' => 'required',      
        ]);

        $consignment->consignerId=$request->consignerId;
        $consignment->consigneeId=$request->consigneeId;
        $consignment->nItems=$request->nItems;
        $consignment->description=$request->description;

        $consignment->vehicleCharges=$request->vehicleCharges;
        $consignment->loadOneCharges=$request->loadOneCharges;
        $consignment->biltyOneCharges=$request->biltyOneCharges;
        $consignment->insurance=$request->insurance;
        $consignment->cartOneCharges=$request->cartOneCharges;
        $consignment->otherCharges=$request->otherCharges;

        $consignment->unloadCharges=$request->unloadCharges;
        $consignment->biltyTwoCharges=$request->biltyTwoCharges;
        $consignment->cartTwoCharges=$request->cartTwoCharges;
        $consignment->loadTwoCharges=$request->loadTwoCharges;
        
        $consignment->receiverName=$request->receiverName;
        
        if($consignment->receiverName==''){
            $consignment->receiverPic=null;
            
        }
        else if($request->receiverPic!=''){
            
            $imageName = time().'.'.$request->receiverPic->extension();  
            $request->receiverPic->move(public_path('uploads'), $imageName);

            $consignment->receiverPic=$imageName;
        }


        $consignment->save();

        //create log
        $log= new log();
        $log->operation="DEL";
        $log->description="Consignment no. ".$consignment->biltyNo." was updated";
        
        $log->save();

        return redirect ('containers/'.$consignment->container->id);
    }

    public function destroy($id)
    {
        //
        $consignment=Consignment::find($id);
        $containerId=$consignment->container->id;
        
        $biltyNo=$consignment->biltyNo;
        $nItems=$consignment->nItems;
        $created_at=$consignment->created_at;
        $consignee=$consignment->consignee->name;

        $consignment->delete();

        //create log
        $log= new log();
        $log->operation="DEL";
        $log->description="Consignment was deleted: Bilty No.:".$biltyNo.", items: ".$nItems.", Consignee: ".$consignee.", created at:".$created_at;
        
        $log->save();

        return redirect ('containers/'.$containerId);
    }

    function searchByDates(Request $request){
        $from    = Carbon::parse($request->from)
                 ->startOfDay()        // 2018-09-29 00:00:00.000000
                 ->toDateTimeString(); // 2018-09-29 00:00:00

        $to      = Carbon::parse($request->to)
                 ->endOfDay()          // 2018-09-29 23:59:59.000000
                 ->toDateTimeString();
        
        $consignments=Consignment::whereBetween('created_at',[$from,$to])->get()->sortByDesc('created_at');
        return view('consignments.index',compact('consignments'));
    }
}
