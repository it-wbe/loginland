<?php
namespace Wbe\Loginland\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Profile extends Controller
{
    public function EditProfile(Request $request){

        if(Auth::user()->email == $request->get('email')){
        $validator  = Validator::make($request->all(),[
            'name' => 'required|max:255|min:4',
            'email' => 'required|email|max:255',
        ]);}
        else{
            $validator  = Validator::make($request->all(),[
                'name' => 'required|max:255|min:4',
                'email' => 'required|email|max:255|unique:users',
            ]);
        }
            if($validator->fails()){
                return response()->json($validator->errors()->toArray());
            }else{
                $user = Auth::user();
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                $user->save();
                return response()->json(['ok'=>'1']);
            }
    }

    public function EditPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'min:6|max:255|',
            'password_confirmation' => 'min:6|max:255|',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray());
        }
        $user = Auth::user();
        $user->password = request('password');
        $user->save();
        return response()->json(['ok'=>'1']);
    }
}