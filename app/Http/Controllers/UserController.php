<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Session;
use App\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('users.create');
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
            'id' => 'required|unique:users',
            'password' => 'required'
        ]);
        
        $user=new User([
            'id' => Str::title($request->id),
            'password' => $request->password,
            
        ]);
        $user->save();

        return redirect ('/users')->with('success','Successfully saved');

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
       // $unloader=unloader::findOrFail($id);

        //return view('unloaders.edit',compact('unloader'));

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
            'status' => 'required',
        ]);
        
       $user=User::find($id);
       
       if($request->status==0) $user->status=1;
       else $user->status=0;
       
       $user->save();

       return redirect ('/users')->with('success','Successfully updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $userId=$user->id;
        $user->delete();

        return redirect ('/users')->with('success','Successfully deleted');
    }

    /**
     * authenticates user and redirects to either admin or user page
     * depending upon user role
     * @param  request
     * @return \Illuminate\Http\Response
     */

    public function auth(Request $request)
    {
        
        $user=User::find($request->id);
        $desc='';

        if(isset($user)){
            
            //create log
            $Log= new Log();
            $Log->operation="LOG";

            if($user->password==$request->password){        //authenticated
                session()->put('id', $user->id);
                session()->put('role', $user->role);

                $Log->description=$user->id." successfully logged in"; 
                $Log->save();          
                
                if($user->role==1)
                  return redirect ('users');
                else
                  return redirect ('containers');
            }else{
                $Log->description=$user->id."'s login attemp failed"; 
                $Log->save();   
            }


        }

        return redirect ('/');
    }

    public function changePassword(){
        return view('users.changePassword');
    }

    public function updatePassword(Request $request){
        $currentPassowrd=$request->currentPassword;
        $newPassword=$request->newPassword;
        $confirmPassword=$request->confirmPassword;

        $id=session()->get('id');

        $user=User::find($id);
        $pw=$user->password;

        $response='';

        if($pw!=$currentPassowrd) $response='Old password incorrect!';
        else if($newPassword!=$confirmPassword) $response='Confirm password not matched!';
        else{

            $user->password=$newPassword;
            $user->save();
            return redirect('/changePassword')->with('success','Password successfully changed!');
        }


        //create log
        $Log= new Log();
        $Log->userId=session()->get('id');
        $Log->operation="UPD";
        $Log->description=$user->id." changed his/her password:";
        
        $Log->save();
       


        return redirect('/changePassword')->with('response',$response);
        
    }

    public function dashboard(){
        if(session()->get('role')==0) return redirect ('containers');
        if(session()->get('role')==1) return redirect ('users');
        return redirect ('/');
    }
    
    public function signout(){
        
        $userId=session()->get('id');

        session()->forget('role');
        
        //create log
        
        $Log= new Log();
        $Log->operation="LOG";
        $Log->description=$userId." logged off";
        
        $Log->save();
       
        return redirect ('/');
    }


}
