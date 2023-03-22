<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userProfile = Auth::user();
        // dd($userProfile);
        if ($userProfile){ return response()->json(['code' => 200, 'data' => $userProfile]);}

    }

    public function editProfile(Request $request, $id) {
        if ($request->bearerToken() != Auth::user()->token) {
            return response()->json([
                'code' => 400,
                'message' => 'Invalid token'
            ]);
        }

        $user = User::find($id);

        return response()->json([
            'code' => 200,
            'message' => 'User Data',
            'data' => $user
        ]);
    }

    // public function addProfile(Request $request){
    //     // dd($request->all());
       
    //     $validator = Validator::make($request->all(),[
	// 		'categories' => 'required',
	// 		'author_name' => 'required',
    //         'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    //     if ($validator->fails()) {
    //         return redirect()->back()->with('error',$validator->errors()->first());
            
    //     }

    //     $addUser = new User;
    //     $addUser->categories = $request->categories;
    //     $addUser->author_name = $request->author_name;

    //     // Profile Image
        
    //     if($request->hasfile('image'))
    //     {
    //         $file = $request->file('image');
    //         $extenstion = $file->getClientOriginalName();
    //         $filename = time().'.'.$extenstion;
    //         $file->move(public_path("images/"), $filename);
    //         $addUser->image = $filename;         
    //     } 
         
    //    $result = $addUser->save();
    //    if ($result){ return response()->json(['code' => 200, 'message' => 'Record has been added successfully'],200);
    // }

    // }

   
    public function updateProfile(Request $request, $id)
    {
        // dd($request);
        
        $updated = User::find($request->id);
        if(!$updated){ return response()->json(['code' => 404, 'message' => 'Record has not exist'],404);}
		$updated->name = $request->name;
		$updated->gender = $request->gender;
		$updated->categories = $request->categories;
		$updated->author_name = $request->author_name;
		$updated->password = Hash::make($request->password);
        $updated->age = $request->age;
        $updated->phone_number = $request->phone_number;
        $updated->address = $request->address;
        $updated->city = $request->city;

         // Update Profile Image

         if($request->hasfile('image'))
         {
            
             $destination = 'images/'.$updated->image;
             if(File::exists($destination))
             {
                 File::delete($destination);
             }
             $file = $request->file('image');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('images/', $filename);
             $updated->image = $filename;
         }

		$result = $updated->save();
		if ($result){ return response()->json(['code' => 200, 'message' => 'Record has been update successfully'],200);}
    }

   
}
