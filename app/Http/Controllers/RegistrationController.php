<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Models\Registration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [ 
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'c_password' => 'required|same:password',
             ]);
         
            if ($validator->fails())
            { 
                $message = $validator->errors()->first();
                return response()->json(['statusCode'=>200,'success'=>false,'message'=>$message], 200);            
            }
                $registration = new User;
                $registration->name = $request->name;
                $registration->password = Hash::make($request->password);
                $registration->email = $request->email;
                $registration->gender = $request->gender;
                $registration->age = $request->age;
                $registration->phone_number = $request->phone_number;
                $registration->address = $request->address;
                $registration->city = $request->city;

                // Profile Image
        
                if($request->hasfile('image'))
                {
                    $file = $request->file('image');
                    $extenstion = $file->getClientOriginalName();
                    $filename = time().'.'.$extenstion;
                    $file->move(public_path("images/"), $filename);
                    $registration->image = $filename;         
                } 

                $result = $registration->save();
                if($result) return response()->json(['code' => 200, 'message' => 'Account registered']);
                if(!$result) return response()->json(['code' => 404, 'message' => 'Account does not exist']);
            }

        catch (Exception $err){
            return response()->json(['code' => 500, 'message' => $err]);
        }
    
    }
}
