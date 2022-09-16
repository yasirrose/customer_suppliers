<?php

namespace App\Http\Controllers\API;
use Auth;
use Validator;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;    
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
         
            'email' => 'required|email',
            'password' => 'required',
            'user_level' => 'required'

        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            
            $user = Auth::user();
            $user_account = UserAccount::where('user_id',$user->id)->where('user_level_id',$request->user_level)->get();

            if(count($user_account) != 1)
            {
                return $this->sendError(['status'=>false,'message'=>'Unauthorized']);
            }

            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            // $success['last_name'] =  $user->last_name;
            $success['user_level_id'] =  $request->user_level;
            $success['id'] =  $user->id;
            

            $cookie_name = "secret";
            $cookie_token = $success['token'];
            setcookie($cookie_name, $cookie_token, time() + 3600, "/");
   
            return $this->sendResponse($success, 'Login successfully.');
        } 
        else{ 
            return $this->sendError(['status'=>false,'message'=>'Unauthorized']);
        } 
    }

    public function logout(Request $request){
        setcookie('secret', '', time() + 3600, "/");
       return $this->sendResponse('Logged Out', 'Logged out successfully.');
    }
}
