<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeDetailsToEmployeessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('employee_code');
            $table->string('old_employee_code');
            $table->string('pan_card_number')->nullable();
            $table->string('aadhaar_card_number')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('employee_code');
            $table->dropColumn('old_employee_code');
            $table->dropColumn('pan_card_number');
            $table->dropColumn('aadhaar_card_number');
        });
    }
}
