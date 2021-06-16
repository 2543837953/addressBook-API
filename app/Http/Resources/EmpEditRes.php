<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpEditRes extends JsonResource
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
            'department_id'=>$this->department->id,
            'category_id'=>$this->category->id,
            'email'=>$this->user->email,
            'username'=>$this->user->name,
            'competence'=>$this->user->competence
        ];
    }
}
