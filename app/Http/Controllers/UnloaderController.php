<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Unloader;

class UnloaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $unloaders=Unloader::all();
        return view('unloaders.index',compact('unloaders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('unloaders.create');
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
        
        $unloader=new Unloader([
            'name' => Str::title($request->get('name')),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'salary' => $request->get('salary')
        ]);
        $unloader->save();
        
        return redirect ('/unloaders')->with('success','Successfully saved');

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
        $unloader=unloader::findOrFail($id);

        return view('unloaders.edit',compact('unloader'));

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
        
       $unloader=unloader::find($id);
       // unloader::whereId($id)->update($validation);

       
        $unloader->name=Str::title($request->get('name'));
        $unloader->phone=$request->get('phone');
        $unloader->address=$request->get('address');
        $unloader->salary=$request->get('salary');
       
        $unloader->save();
        
        return redirect ('/unloaders')->with('success','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unloader=unloader::find($id);
        $unloader->delete();
        return redirect ('/unloaders')->with('success','Successfully deleted');
    }
}
