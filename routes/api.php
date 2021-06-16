<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login',[\App\Http\Controllers\UserController::class,'index']);
Route::post('logout',[\App\Http\Controllers\UserController::class,'logout']);
Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::get('employees/list',[\App\Http\Controllers\EmployeeController::class,'empPaging']);
    Route::get('employees/list/{id}',[\App\Http\Controllers\EmployeeController::class,'empDes']);
    Route::get('employees/list/edit/{id}',[\App\Http\Controllers\EmployeeController::class,'empEditDes']);
    Route::put('employees/list/edit/{id}',[\App\Http\Controllers\EmployeeController::class,'empEdit']);
    Route::get('employees/search/{val}',[\App\Http\Controllers\EmployeeController::class,'empSearch']);
    Route::get('employees/del/{loginId}/{id}',[\App\Http\Controllers\EmployeeController::class,'empDel']);
    Route::post('employees/list/new',[\App\Http\Controllers\EmployeeController::class,'newEmp']);
    Route::get('department',[\App\Http\Controllers\DepartmentController::class,'list']);
    Route::post('department/new',[\App\Http\Controllers\DepartmentController::class,'newDe']);
    Route::get('department/del/{id}',[\App\Http\Controllers\DepartmentController::class,'delDe']);
    Route::get('department/list',[\App\Http\Controllers\DepartmentController::class,'departmentAll']);
    Route::get('department/{id}/{val}',[\App\Http\Controllers\DepartmentController::class,'department']);
    Route::get('category',[\App\Http\Controllers\CategoryController::class,'list']);
    Route::get('category/{id}',[\App\Http\Controllers\CategoryController::class,'category']);

});

