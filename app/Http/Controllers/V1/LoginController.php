<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;

class LoginController extends ApiController
{
    /**
     * Login
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request){
        try {
            $credential = $request->only(['email' , 'password']);
            $rules = [
                'email'     => 'required|email',
                'password'  => 'required'
            ];
            $messages = [];
            $validator = Validator::make($credential, $rules, $messages);
            if($validator->fails()){
                return response()->error($validator->errors());
            }
            if(!$token = JWTAuth::attempt($credential)){
                return response()->error('Email or password is wrong', 400);
            }

            return response()->success($token);
        }
        catch (\Exception $exception){
            return response()->error('This api error', 500);
        }
    }
}
