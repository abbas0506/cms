<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Consigner;

class ConsignerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $consigners=Consigner::all();
        return view('consigners.index',compact('consigners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('consigners.create');
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
        
        $consigner=new Consigner([
            'name' => Str::title($request->get('name')),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'address' => $request->get('address')
        ]);
        $consigner->save();

        return redirect ('/consigners')->with('success','Successfully saved');

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
        $consigner=Consigner::findOrFail($id);

        return view('consigners.edit',compact('consigner'));

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
        
        $consigner=Consigner::find($id);

        //hold previous values for activity log entry
        $previousName=$consigner->name;
        $previousPhone=$consigner->phone;
              
        $consigner->name=Str::title($request->get('name'));
        $consigner->phone=$request->get('phone');
        $consigner->email=$request->get('email');
        $consigner->address=$request->get('address');
       
        $consigner->save();

        //create log
        
        return redirect ('/consigners')->with('success','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consigner=Consigner::find($id);

        //hold name for activity log
        $previousName=$consigner->name;

        $consigner->delete();

        //create log
        return redirect ('/consigners')->with('success','Successfully deleted');
    }
}
