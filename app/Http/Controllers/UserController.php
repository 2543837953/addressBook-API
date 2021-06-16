<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class UserController extends Controller
{
    public function index(Request $request){
        $mobile=$request->get('mobile');
        $emp=Employee::where('mobile',$mobile)->first();
        $user=$emp->user;
        if (!$user||!Hash::check($request->get('password'),$user->password)){
            return response(['message'=>'These credentials do to match our records.'],404);
        }
        $token=$user->createToken('my-app-token')->plainTextToken;
//        dd($user->createToken('my-app-token'));
        $response=[
            'user'=>[
                'id'=>$user->id,
                'empId'=>$user->employee->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'department'=>$user->employee->department->name,
                'admin'=>$user->competence==='root'?1:0,
                'department_admin'=>$user->competence==='admin'?1:0,
            ],
            'token'=>$token
        ];
        return response($response,200);
    }
    public function logout(Request $request){
        if ($token=$request->bearerToken()){
            $model=Sanctum::$personalAccessTokenModel;
            $model::findToken($token)->delete();
            return response([
                'message'=>'success'
            ],200);
        }
    }
}
