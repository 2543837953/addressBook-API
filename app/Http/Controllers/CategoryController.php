<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryAllRes;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list(){
        return response([
            'message'=>'success',
            'data'=>CategoryAllRes::collection(Category::all())
        ]);
    }
    public function category($id){
        $emp=Category::where('id',$id)->first();
        if (!$emp){
            return response([
                'message'=>'not found'
            ],404);
        }
        return response(['message'=>'success','data'=>CategoryAllRes::make($emp)]);
    }
}
