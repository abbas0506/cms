<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Forwarder;

class ForwarderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $forwarders=Forwarder::all();
        return view('forwarders.index',compact('forwarders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('forwarders.create');
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
        
        $forwarder=new forwarder([
            'name' => Str::title($request->get('name')),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'address' => $request->get('address')
        ]);
        $forwarder->save();

               
        return redirect ('/forwarders')->with('success','Successfully saved');

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
        $forwarder=forwarder::findOrFail($id);

        return view('forwarders.edit',compact('forwarder'));

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
        
        $forwarder=forwarder::find($id);
         
        //hold previous values for activity log entry
        $previousName=$forwarder->name;
        $previousPhone=$forwarder->phone;


        $forwarder->name=Str::title($request->get('name'));
        $forwarder->phone=$request->get('phone');
        $forwarder->email=$request->get('email');
        $forwarder->address=$request->get('address');
       
        $forwarder->save();

        return redirect ('/forwarders')->with('success','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $forwarder=forwarder::find($id);

        $forwarder->delete();
        return redirect ('/forwarders')->with('success','Successfully deleted');
    }


}
