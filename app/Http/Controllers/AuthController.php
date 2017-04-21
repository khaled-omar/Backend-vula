<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
    /**
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Register(Request $request)
    {
        //  Validate input..
        $this->validate($request,[
            'name'=>'required|min:3|max:191',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|alpha_num'

            ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        if($user->save())
        {
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'msg'=>'user Created successfuly',
                'user'=>$user,
                'token'=>$token,
                'signin'=>[
                    'Method'=>'POST',
                    'url'=>'api/v1/login',
                    'params' => 'email, password'
                    ]
                ],200);

        }

        return response()->json(['msg'=>'user Creation failed'],401);


    }
     /**
     * CHeck if User found in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function Login(Request $request)
     {
        //validate input .
        $this->validate($request,[
            'email'=>'required|email|min:5',
            'password'=>'required|min:5|numeric'
            ]);

        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid email or password'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could not create token'], 500);
        }
        $user = User::where('email',$request->email)->first();
        // all good so return the token
         return response()->json(['token'=>$token,'user'=>$user]);
     }


 }
