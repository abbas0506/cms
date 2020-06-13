<?php
  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Forwarder;
use App\Consigner;
use App\Consignee;
use App\Log;
   
class AjaxController extends Controller
{
    public function addForwarder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
        
        $forwarder=new forwarder([
            'name' => Str::title($request->name),
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);
        
        $forwarder->save();

        //create log

        $log= new Log();
        $log->operation="ADD";
        $log->description="Forwarder was added: ".$forwarder->name;

        $log->save();

        //send back response
        $currentId=$forwarder->id;
        $forwarders=Forwarder::select('id','name')->get();
                
        $res='';
        
        foreach($forwarders as $forwarder){
            
            if($forwarder->id==$currentId)
                $res=$res."<option value='".$forwarder->id."' selected>".$forwarder->name."</option>";
            else
                $res=$res."<option value='".$forwarder->id."'>".$forwarder->name."</option>";

        }

        return response()->json(["success"=>$res]);
    }

    public function addConsigner(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
        
        
        $consigner=new Consigner([
            'name' => Str::title($request->name),
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);
        
        $consigner->save();

        //create log

        $log= new Log();
        $log->operation="ADD";
        $log->description="Consigner was added: ".$consigner->name;

        $log->save();

        //send back response

        $currentId=$consigner->id;
        $consigners=Consigner::select('id','name')->get();
                
        $res='';
        
        
        foreach($consigners as $consigner){
            if($consigner->id==$currentId)
                $res=$res."<option value='".$consigner->id."' selected>".$consigner->name."</option>";
            else
               $res=$res."<option value='".$consigner->id."'>".$consigner->name."</option>"; 

        }

        return response()->json(["success"=>$res]);
    }

    public function addConsignee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
        
        $consignee=new Consignee([
            'name' => Str::title($request->name),
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);
        $consignee->save();

        //create log

        $log= new Log();
        $log->operation="ADD";
        $log->description="Consignee was added: ".$consignee->name;

        $log->save();

        //send back reponse

        $currentId=$consignee->id;
        $consignees=Consignee::select('id','name')->get();
        
        $res='';
        
        foreach($consignees as $consignee){
            if($consignee->id==$currentId)
                $res=$res."<option value='".$consignee->id."' selected>".$consignee->name."</option>";
            else
                $res=$res."<option value='".$consignee->id."'>".$consignee->name."</option>";       
        }

        return response()->json(["success"=>$res]);
  
    }
   
}