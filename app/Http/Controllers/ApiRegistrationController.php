<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;

class ApiRegistrationController extends Controller
{
    public function registration(Request $request){
        $data = $request->all();
        $validator = $this->validator($data);
        if(!$validator->fails()){
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }else{
            return response()->json($validator->errors()->all(),400);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
}
