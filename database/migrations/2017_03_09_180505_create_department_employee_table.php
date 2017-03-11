<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_employee', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('department_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->primary(['department_id', 'employee_id']);
            $table->foreign('department_id')
                ->references('department_id')->on('departments')
                ->onUpdate('cascade');
            $table->foreign('employee_id')
                ->references('employee_id')->on('employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_employee');
    }
}
