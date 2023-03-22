<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\UpdateLoginRequest;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as RulesPassword;

class LoginController extends Controller
{
    public function login(Request $request){
		try{
            // dd('dddd');
			$user = User::where('email',$request->email)->get()->first();
			if(!$user) return response()->json(['code' => 404, 'message' => 'Account does not exist']);
			if(!Hash::check($request->password, $user->password)) return response()->json(['status' => 400, 'msg' => 'Email and Password not match']);
			if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
                $token = Auth::user()->createToken('api-application')->accessToken;
				// dd($token)
				$user->token = $token;
				$user->save();
                return response()->json(['code' => 200, 'token'  => $token,  'data' => $user]);
			}
		}
		catch (Exception $err){
			return response()->json(['code' => 500, 'message' => $err]);
		}

	}

	public function logout(Request $request) {
        // dd('admin');
        Auth::logout();
        $request->session()->invalidate();
    	$request->session()->regenerateToken();
        return redirect()->route('login');
    }

	public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

		$user = User::where('email',$request->email)->get()->first();
		if(!$user) return response()->json(['code' => 404, 'message' => 'Account does not exist']);
		if($user) return response()->json(['code' => 200, 'message' => $user]);

        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // if ($status == Password::RESET_LINK_SENT) {
        //     return [
        //         'status' => __($status)
        //     ];
        // }

        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
    }

    public function reset(Request $request)
    {
        $updatedPassword = User::find($request->id);
		if(!$updatedPassword){ return response()->json(['code' => 404, 'message' => 'Password has been not update successfully'],404);}
		$updatedPassword->password = Hash::make($request->password);
		$result = $updatedPassword->save();
		if ($result){ return response()->json(['code' => 200, 'message' => 'Password has been update successfully'],200);}

		
//         $request->validate([
//             'token' => 'required',
//             'email' => 'required|email',
//             'password' => ['required', 'confirmed', RulesPassword::defaults()],
//         ]);

//         $status = Password::reset(
//             $request->only('email', 'password', 'password_confirmation', 'token'),
//             function ($user) use ($request) {
//                 $user->forceFill([
//                     'password' => Hash::make($request->password),
//                     'remember_token' => Str::random(60),
//                 ])->save();

//                 $user->tokens()->delete();

//                 event(new PasswordReset($user));
//             }
//         );
// // dd($status);
//         if ($status == Password::PASSWORD_RESET) {
//             return response([
//                 'message'=> 'Password reset successfully'
//             ]);
//         }

//         return response([
//             'message'=> __($status)
//         ], 500);

    }
	// public function checkToken(){
	// 	return response()->json(['code' => 200, 'message' => 'Token is authorized'],200);
	// }
}
