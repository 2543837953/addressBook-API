<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmpEditRes;
use App\Http\Resources\EmployeeRes;
use App\Models\Employee;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function list(){
        return response(['message'=>'success','data'=>EmployeeRes::collection(Employee::all())]);
    }
    public function empDes($id){
        $emp=Employee::where('id',$id)->first();
        if (!$emp){
            return response(['message'=>'not found'],404);
        }
        return response(['message'=>'success','data'=>EmployeeRes::make($emp)]);
    }
    public function empEditDes($id){
        $emp=Employee::where('id',$id)->first();
        if (!$emp){
            return response(['message'=>'not found'],404);
        }
        return response(['message'=>'success','data'=>EmpEditRes::make($emp)]);
    }
    public function empEdit($id,Request $request){
        $emp=Employee::where('id',$id)->first();
        $user=User::where('id',$id)->first();
        if (!$emp||!$user){
            return response(['message'=>'not found'],404);
        }
        $v=Validator::make($request->all(),
                [
                    'name'=>'required',
                    'gender'=>'required',
                    'email'=>'required',
                    'mobile' => 'required',
                    'post_title'=>'required',
                    'department_id'=>'required',
                    'category_id'=>'required',
                    'username'=>'required',
                    'competence'=>'required'
                ]
            );
        if ($v->fails()){
            return response()->json([
                'msg'=>'提交内容不能为空'
            ],422);
        }
        $empPhone=Employee::where('mobile',$request->get('mobile'))->first();
        if ($empPhone&&$empPhone->mobile!==$emp->mobile){
            return response()->json([
                'msg'=>'电话号码重复使用'
            ],402);
        }
        $email=User::where('email',$request->get('email'))->first();
        if ($email&&$user->email!==$email->email){
            return response()->json([
                'msg'=>'邮箱重复使用'
            ],423);
        }
        $user->competence=$request->get('competence');
        $user->email=$request->get('email');
        $user->name=$request->get('username');
        $emp->name=$request->get('name');
        $emp->birth_date=$request->get('birth_date');
        $emp->gender=$request->get('gender');
        $emp->mobile=$request->get('mobile');
        $emp->post_title=$request->get('post_title');
        $emp->department_id=$request->get('department_id');
        $emp->category_id=$request->get('category_id');
        $emp->department_admin=$request->get('competence')==='admin'?1:0;
        $emp->admin=$request->get('competence')==='root'?1:0;
        if ($emp->save()&&$user->save()){
            return response()->json([
                'msg'=>'success'
            ],200);
        }
    }
    public function empPaging(){
        $emp=Employee::paginate(10);
        return response([
            'message'=>'success',
            'pageCount'=>$emp->lastPage(),
            'data'=>EmployeeRes::collection($emp)

        ]);
    }
    public function empSearch($val){
        $emp=Employee::where('name','like','%'.$val.'%')->orWhere('mobile','like',$val.'%')->paginate(10);
        return response([
            'message'=>'success',
            'pageCount'=>$emp->lastPage(),
            'data'=>EmployeeRes::collection($emp)
        ]);
    }
    public function empDel($loginId,$id){
        $loginUser=User::find($loginId);
        $emp=Employee::find($id);
        if (!$loginUser||!$emp){
            return response([
               'message'=>'not found'
            ],404);
        }
        $departmentUser=$loginUser->employee->department->name;
        $departmentEmp=$emp->department->name;
        if ($loginUser->competence==='root'||($emp->user->competence!=='root'&&$loginUser->competence==='admin'&&$departmentUser===$departmentEmp&&$loginUser->id!==$emp->id)){
            $res=$emp->delete();
            if ($res){
                return response([
                    'message'=>'success'
                ],200);
            }
        }else{
            return response([
                'message'=>'forbidden'
            ],403);
        }

    }
    public function newEmp(Request $request){
        $v=Validator::make($request->all(),
            [
                'name'=>'required',
                'gender'=>'required',
                'email'=>'required',
                'mobile' => 'required',
                'post_title'=>'required',
                'department_id'=>'required',
                'category_id'=>'required',
                'username'=>'required',
                'competence'=>'required'
            ]
        );
        if ($v->fails()){
            return response()->json([
               'msg'=>'提交内容不能为空'
            ],422);
        }
        $emp=Employee::where('mobile',$request->get('mobile'))->first();
        if ($emp){
            return response()->json([
                'msg'=>'电话号码重复使用'
            ],402);
        }
        $email=User::where('email',$request->get('email'))->first();
        if ($email){
            return response()->json([
                'msg'=>'邮箱重复使用'
            ],423);
        }
        DB::beginTransaction();
        try {
            $user=User::create([
                'name'=>$request->get('username'),
                'competence'=>$request->get('competence'),
                'email'=>$request->get('email'),
                'password'=>Hash::make('123456')
            ]);
            if ($user->save()){
                $emp=Employee::create([
                    'name'=>$request->get('name'),
                    'birth_date'=>$request->get('birth_date'),
                    'gender'=>$request->get('gender'),
                    'mobile'=>$request->get('mobile'),
                    'post_title'=>$request->get('post_title'),
                    'department_id'=>$request->get('department_id'),
                    'category_id'=>$request->get('category_id'),
                    'department_admin'=>$request->get('competence')==='admin'?1:0,
                    'admin'=>$request->get('competence')==='root'?1:0,
                    'user_id'=>$user->id
                ]);

            }
        }catch (\Exception $e){
            return response()->json(['msg' => $e->getMessage()], 401);
        }
        DB::commit();
        if ($emp->save()){
            return response()->json([
                'msg'=>'success'
            ],200);
        }
    }
}
