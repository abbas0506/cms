<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Container;
use App\Consignment;
use App\Forwarder;
use App\Log;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index($mode=10)
    {
                
        if($mode==10){
            $containers=Container::limit(10)->orderBy('id','desc')->get();
            return view('containers.index',compact('containers','mode'));
        }
        else{
            $containers=Container::all();
            return view('containers.index',compact('containers','mode'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forwarders=Forwarder::select('id','name')->get();
        return view('containers.create', compact('forwarders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            'forwarderId' => 'required',
            'vehicleNo' => 'required',
            'carrierName' => 'required',
            'commission' => 'required',
            
        ]);
        
        $container=new container([
            'forwarderId' => $request->get('forwarderId'),
            'vehicleNo' => Str::upper($request->get('vehicleNo')),
            'carrierName' => Str::title($request->get('carrierName')),
            'carrierPhone' => $request->get('carrierPhone'),
            'commission' => $request->get('commission'),
           
        ]);
        
        $container->save();

        //create log
        
        $log= new Log();
        $log->operation="ADD";
        $log->description="Container was added: vehicle".$container->vehicleNo." driven by ".$container->carrierName." on ".$container->created_at;

        $log->save();
        
        return redirect ('/containers')->with('success','Successfully saved');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $container=Container::find($id);
        
        return view('containers.show', compact('container'));
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $container=Container::findOrFail($id);
        $forwarder=Container::find($id)->forwarder;

        return view('containers.edit', compact('container'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            
            'vehicleNo' => 'required',
            'carrierName' => 'required',
            'commission' => 'required',
        ]);
        
        $container=Container::find($id);

        //hold name for activity log
        $vehicleNo=$container->vehicleNo;
        $carrierName=$container->carrierName;
        
        $container->vehicleNo = Str::upper($request->vehicleNo);
        $container->carrierName = Str::title($request->carrierName);
        $container->carrierPhone = $request->carrierPhone;
        $container->commission = $request->commission;
        
        $container->save();

        //create log
        $log= new log();
        $log->operation="UPD";
        $log->description="Container was updated: ".$vehicleNo." -> ".$container->vehicleNo. ", ".$carrierName;
        
        $log->save();


        return redirect ('/containers')->with('success','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $container=Container::find($id);

        //hold name for activity log
        $vehicleNo=$container->vehicleNo;
        $carrierName=$container->carrierName;
        $created_at=$container->created_at;

        $container->delete();

        //create log
        $log= new log();
        $log->operation="DEL";
        $log->description="Container was deleted: No. ".$vehicleNo." driven by ".$carrierName." dated ".$created_at;
        
        $log->save();

        return redirect ('/containers')->with('success','Successfully deleted');
    }
}
