<?php

namespace App\Http\Controllers;
use App\Consignee;
use App\Recovery;
use App\Batch;
use App\Log;

use Illuminate\Http\Request;

class BatchedRecoveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            
            'consigneeId' => 'required',
            'amount' => 'required',
            'batchId' => 'required',
        ]);
        
        $recovery = new Recovery([
            'consigneeId' => $request->consigneeId,
            'amount' => $request->amount,
            'description' => $request->description,
            'batchId' => $request->batchId,
        ]);
        
        $recovery->save();

        //create log
        $log= new Log();
        $log->operation="ADD";
        $consignee=Consignee::find($request->consigneeId);
        $log->description="Recovery was made from consignee. ".$consignee->name.", amount: ".$recovery->amount;

        $log->save();
        
        $batch=Batch::find($request->batchId);
        $consignees=Consignee::all();
        return view('batches.show',compact('batch','consignees'));   //show recoveries of current consignee
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $recovery=Recovery::findOrFail($id);

        return view('recovery.edit',compact('recovery'));
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
        //
        $request->validate([
            'amount' => 'required',
        ]);
        
        $recovery=Recovery::findOrFail($id);
        $consignee=Consignee::findOrFail($recovery->consignee->id);
        $preAmount=$recovery->amount;
        $recovery->amount=$request->amount;
        $recovery->description=$request->description;
        
        $recovery->save();

        //create log
        $log= new Log();
        $log->operation="UPD";
        $log->description="Recovery was updated. Consignee ".$consignee->name.", from: ".$preAmount." to ".$recovery->amount;
        
        $log->save();

        $batch=Batch::find($recovery->batchId);
        $consignees=Consignee::all();
        return view('batches.show',compact('batch','consignees'));   //show recoveries of current consignee
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $recovery=Recovery::findOrFail($id);
        $consignee=Consignee::findOrFail($recovery->consignee->id);
        $batchId=$recovery->batchId;
        $amount=$recovery->amount;  //for log entry
       
        $recovery->delete();

        //create log
        $log= new Log();
        $log->operation="DEL";
        $log->description="Recovery was deleted. Consignee ".$consignee->name.", amount: ".$recovery->amount;

        $log->save();

        $batch=Batch::find($batchId);
        $consignees=Consignee::all();
        return view('batches.show',compact('batch','consignees'));   //show recoveries of current consignee

    }
}
