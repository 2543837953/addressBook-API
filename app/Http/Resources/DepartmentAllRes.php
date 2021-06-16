<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentAllRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $es=[];
        foreach ($this->employees as $e){
            $es[]=[
                'id'=>$e->id,
                'name'=>$e->name,
                'gender'=>$e->gender,
                'birth_date'=>$e->birth_date,
                'mobile'=>$e->mobile,
                'post_title'=>$e->post_title,
                'department'=>$e->department->name,
                'category'=>$e->category->name,
                'email'=>$e->user->email,
                'admin'=>$e->user->competence==='root'?1:0,
                'department_admin'=>$e->user->competence==='admin'?1:0
            ];
        }
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'telephone'=>$this->telephone,
            'location'=>$this->location,
            'pageCount'=>count(array_chunk($es,10)),
            'employees'=>array_chunk($es,10)[$request->get('val')-1]
        ];
    }
}
