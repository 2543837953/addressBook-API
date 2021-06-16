<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentAllRes;
use App\Http\Resources\DepartmentEmpRes;
use App\Http\Resources\DepartmentRes;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class DepartmentController extends Controller
{
    public function list()
    {
        return response([
            'message' => 'success',
            'data' => DepartmentAllRes::collection(Department::all())
        ]);
    }

    public function departmentAll()
    {
        return response([
            'message' => 'success',
            'data' => DepartmentRes::collection(Department::all())
        ]);
    }

    public function newDe(Request $request)
    {
        $v = Validator::make($request->all(),
            [
                'department' => 'required',
                'telephone' => 'required|regex:/^1\d{10}$/'
            ]
        );
        if ($v->fails()) {
            return response()->json(['msg' => '内容不能为空'], 422);
        }
        $d = $request->get('department');
        $phone = $request->get('telephone');
        $inspect=Department::where('name',$d)->first();
        $inspectPhone=Department::where('telephone',$phone)->first();
        if ($inspect||$inspectPhone){
            return response()->json(['msg' => '该部门已存在或者电话号码重复使用'], 422);
        }
        $address = $request->get('location');
        $de = new Department();
        $de->name = $d;
        $de->telephone =$phone;
        $de->location=$address||'';
        if ($de->save()) {
            return response()->json(['msg' => 'success'], 200);
        }
    }

    public function department($id, $val, Request $request)
    {
        $emp = Department::where('id', $id)->first();
        if (!$emp) {
            return response([
                'msg' => 'not found'
            ], 404);
        }
        $request['val'] = $val;
        return response(['msg' => 'success', 'data' => DepartmentAllRes::make($emp)]);
    }
    public function delDe($id){
        $d=Department::find($id);
        if (!$d){
            return response([
                'msg' => 'not found'
            ],404);
        }
        if(empty($d->employees[0])){
            $d->delete();
            return response([
                'message' => 'success'
            ],200);
        }else{
            return response()->json(
                [
                    'msg' => '该部门还存在成员不能删除'
                ],406);
        }
    }
}
