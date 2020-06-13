<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Consignee;
use App\ActivityLog;

class ConsigneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $consignees=Consignee::all();
        return view('consignees.index',compact('consignees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('consignees.create');
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
            'name' => 'required',
            'phone' => 'required'
        ]);
        
        $consignee=new consignee([
            'name' => Str::title($request->get('name')),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'address' => $request->get('address')
        ]);
        $consignee->save();

        //create log
        
        return redirect ('/consignees')->with('success','Successfully saved');

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
        $consignee=consignee::findOrFail($id);

        return view('consignees.edit',compact('consignee'));

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
            'name' => 'required',
            'phone' => 'required'
        ]);
        
        $consignee=consignee::find($id);
        
        //hold previous values for activity log entry
        $previousName=$consignee->name;
        $previousPhone=$consignee->phone;
       
        $consignee->name=Str::title($request->get('name'));
        $consignee->phone=$request->get('phone');
        $consignee->email=$request->get('email');
        $consignee->address=$request->get('address');
       
        $consignee->save();

        //create log
        
        return redirect ('/consignees')->with('success','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consignee=consignee::find($id);
        
        //hold name for activity log
        $previousName=$consignee->name;
        
        $consignee->delete();

        //create log
        
        return redirect ('/consignees')->with('success','Successfully deleted');
    }
}
