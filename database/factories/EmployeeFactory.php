<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender=$this->faker->randomElement(['男','女']);
        $g=$gender=='男'?'male':'female';
        return [
            'name'=>$this->faker->lastName.$this->faker->firstName($g),
            'gender'=>$gender,
            'birth_date'=>$this->faker->dateTimeBetween('-60 years','-18 years'),
            'mobile'=>$this->faker->randomElement(['130','133','139','180','189']).$this->faker->numerify('########'),
            'post_title'=>$this->faker->randomElement(['助理讲师','讲师','高级讲师']),
            'department_admin'=>0,
            'admin'=>0,
            'department_id'=>$this->faker->randomElement([1,2,3,4,5]),
            'category_id'=>$this->faker->randomElement([1,2,3,4])
        ];
    }
}
