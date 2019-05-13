<?php

/*
 *
 * @coded by: Tharuka Lakshan
 * @date    : 29/04/19
 *
 * description: update profile, login, register, profile details
 *
 */

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Role;
use App\Util\ApiWrapper;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;

class UserController extends Controller
{




    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token =  $user->createToken('MyApp')-> accessToken;
            return ApiWrapper::wrapApiResponse(['token'=> $token, 'user' => $user], 'authorised', 200);
        }
        else{
            return ApiWrapper::wrapApiResponse(['message'=>'You entered email and password does not match'], 'Unauthorised', 401);
        }
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return ApiWrapper::wrapApiResponse(['error'=>$validator->errors()], 'error_in_fields', 401);
        }

        $input = $request->all();
        $user = User::where('email', $input['email'])->first();

        if($user != null)
        {
           return ApiWrapper::wrapApiResponse(['message'=>'Account has been registered with this email'], 'duplicate_email', 401);
        }


        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user
            ->roles()
            ->attach(Role::where('name', 'user')->first());

        UserVerification::generate($user);
        UserVerification::send($user, 'Email verification Sri-Rewards');

        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return ApiWrapper::wrapApiResponse(['user'=>$user,'message'=>'You have successfully registered'], 'success', 200);
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return ApiWrapper::wrapApiResponse(['user'=>$user], 'success', 200);

    }

    /**
     *password reset request api
     *
     *@return \Illuminate\Http\Response
     */
    public function passwordResetRequest()
    {
       // return ApiWrapper::wrapApiResponse(['user'=>$user], 'success', 200);
    }

    /**
     *password reset request confirm api
     *
     *@return \Illuminate\Http\Response
     */
    public function passwordResetRequestConfirm()
    {
        //return ApiWrapper::wrapApiResponse(['user'=>$user], 'success', 200);
    }
}
