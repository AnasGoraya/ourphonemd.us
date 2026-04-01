<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixAppointmentsDoctorForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the existing foreign key constraint pointing to doctors table
            $table->dropForeign(['doctor_id']);

            // Add new foreign key constraint pointing to users table
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the foreign key constraint pointing to users table
            $table->dropForeign(['doctor_id']);

            // Restore the original foreign key constraint pointing to doctors table
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }
}
