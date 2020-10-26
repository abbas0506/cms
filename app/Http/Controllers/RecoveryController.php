<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consignee;
use App\Recovery;
use App\Log;

class RecoveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $consignees=Consignee::orderBy('name')->get();
        return view('recovery.index',compact('consignees'));
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
        ]);
        
        $recovery = new Recovery([
            'consigneeId' => $request->consigneeId,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        
        $recovery->save();

        $consignee=Consignee::findOrFail($recovery->consignee->id);

        //create log
        $log= new Log();
        $log->operation="ADD";
        $log->description="Recovery was made from consignee. ".$consignee->name.", amount: ".$recovery->amount;

        $log->save();
        
        $consignee=Consignee::find($request->consigneeId);
        return redirect('recoveries/'.$recovery->consignee->id);    //show recoveries of current consignee
        
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
        $consignee=Consignee::find($id);
        $recoveries=$consignee->recoveries()->selectRaw("created_at, description, amount, 'db' as 'tx'");
        $mixedTransactions=$consignee->consignments()->selectRaw("created_at, description, vehicleCharges+
                loadOneCharges+
                biltyOneCharges+
                insurance+
                cartOneCharges+
                otherCharges+
                unloadCharges+
                biltyTwoCharges+
                cartTwoCharges+
                loadTwoCharges as amount, 'cr' as 'tx'" )->union($recoveries)->orderByDesc('created_at')->limit(8)->get();
        
        
        return view('recovery.show',compact('consignee','mixedTransactions'));
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

        return redirect('recoveries/'.$recovery->consignee->id);
        

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
        
        $amount=$recovery->amount;  //for log entry
       
        $recovery->delete();

        //create log
        $log= new Log();
        $log->operation="DEL";
        $log->description="Recovery was deleted. Consignee ".$consignee->name.", amount: ".$recovery->amount;

        $log->save();

        return redirect('recoveries/'.$consignee->id);

    }
}
