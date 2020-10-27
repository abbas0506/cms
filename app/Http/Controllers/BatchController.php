<?php

namespace App\Http\Controllers;
use App\Batch;
use App\Consignee;
use App\Log;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $batches=Batch::orderByDesc('id')->get();
        return view('batches.index',compact('batches'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $batch=new batch();
        $batch->save();
        $consignees=Consignee::all();
        
        return view('batches.show',compact('batch','consignees'));

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
        $batch=Batch::find($id);
        $consignees=Consignee::all();
        
        return view('batches.show',compact('batch','consignees'));

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
        $batch=Batch::findOrFail($id);
        $batchId=$batch->id;
        $amount=$batch->getTotal();
        $batch->delete();

        //create log
        $log= new Log();
        $log->operation="DEL";
        $log->description="Bacth ".$batchId." was deleted: amount= ".$amount;

        $log->save();

        $batches=Batch::orderByDesc('id')->get();
        return view('batches.index',compact('batches'));
    }
}
