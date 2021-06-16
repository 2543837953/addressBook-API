<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->char('gender',3);
            $table->date('birth_date')->nullable();
            $table->string('mobile',20)->unique();
            $table->string('post_title',255);
            $table->tinyInteger('department_admin');
            $table->tinyInteger('admin');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE employees ADD CONSTRAINT check_gender check ( gender in ('男','女'))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
