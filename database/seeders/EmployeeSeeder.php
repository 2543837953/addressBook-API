<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create('zh_CN');
        foreach (['行政管理','专职教师','外聘人员','工人'] as $i=>$c ){
            DB::table('categories')->insert([
                'id'=>$i+1,
                'name'=>$c
            ]);
        };
        foreach (['信息技术系','建筑工程系','教务处','人事处','化学工程系'] as $i=>$d){
            DB::table('departments')->insert([
                'id'=>$i+1,
                'name'=>$d,
                'telephone'=>$faker->unique()->phoneNumber,
            ]);
        }
       User::factory()->hasEmployee(1)->count(200)->create();
    }
}
