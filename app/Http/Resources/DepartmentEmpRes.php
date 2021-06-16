<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentEmpRes extends JsonResource
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
            ];
        }
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'telephone'=>$this->telephone,
            'location'=>$this->location,
            'number'=>count($es),
            'employees'=>$es
        ];
    }
}
