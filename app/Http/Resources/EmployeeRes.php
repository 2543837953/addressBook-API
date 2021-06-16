<?php

namespace App\Http\Resources;

use App\Models\Department;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'gender'=>$this->gender,
            'birth_date'=>$this->birth_date,
            'mobile'=>$this->mobile,
            'post_title'=>$this->post_title,
            'department'=>$this->department->name,
            'category'=>$this->category->name,
            'email'=>$this->user->email,
            'admin'=>$this->user->competence==='root'?1:0,
            'department_admin'=>$this->user->competence==='admin'?1:0
        ];
    }
}
