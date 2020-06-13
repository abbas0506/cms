<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Log;

class PaymentController extends Controller
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
            'containerId' => 'required',
            'amount' => 'required',
                                    
        ]);
        
        $payment=new Payment([
            'containerId'=>$request->containerId,
            'amount' => $request->amount,
        ]);
        
        
        $payment->save();

        //create log
        $log= new Log();
        $log->operation="ADD";
        $log->description="Payment was made to container no. ".$payment->containerId.", amount: ".$payment->amount;

        $log->save();
        
        return redirect ('containers/'.$request->containerId)->with('success','Successfully added');;
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
            'id' => 'required',
            'amount' => 'required',                            
        ]);

        $id=$request->id;
        $payment=Payment::findOrFail($id);
        $preAmount=$payment->amount;        //previous amount

        $payment->amount=$request->amount;
        $payment->save();

        //create log
        $log= new Log();
        $log->operation="UPD";
        $log->description="Payment was updated: container no. ".$payment->containerId.", from: ".$preAmount." to ".$payment->amount;

        $log->save();
        return redirect('containers/'.$payment->containerId)->with('success','Successfully updated');
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
        $payment=Payment::findOrFail($id);
        $current=$payment;
        $payment->delete();

        //create log
        $log= new Log();
        $log->operation="DEL";
        $log->description="Payment was deleted: container no. ".$payment->containerId.", amount: ".$payment->amount;

        $log->save();
        return redirect('containers/'.$current->containerId)->with('success','Successfully deleted');;
    }
}
