<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManagerDetailsToManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('managers', function (Blueprint $table) {
            $table->string('manager_last_name');
            $table->integer('manager_branch_id');
            $table->string('date_of_birth')->nullable();
            $table->string('gender');
            $table->string('address')->nullable();
            $table->integer('manager_department_id');
            $table->integer('manager_type')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('managers', function (Blueprint $table) {
            $table->dropColumn('manager_branch_id');
            $table->dropColumn('manager_department_id');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('address');
            $table->dropColumn('manager_last_name');

        });
    }
}
