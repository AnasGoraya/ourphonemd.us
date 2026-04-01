<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixAppointmentDoctorIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update appointments to use correct doctor IDs from users table
        // This migration fixes any appointments that might have wrong doctor_id values
        // by ensuring they reference valid doctors (role_id = 5) in the users table

        // First, let's get all appointments and check their doctor_ids
        $appointments = DB::table('appointments')->get();

        foreach ($appointments as $appointment) {
            // Check if the doctor_id exists in users table with role_id = 5
            $doctorExists = DB::table('users')
                ->where('id', $appointment->doctor_id)
                ->where('role_id', 5)
                ->exists();

            if (!$doctorExists) {
                // If doctor doesn't exist, we need to assign a default doctor
                // Let's find the first active doctor
                $defaultDoctor = DB::table('users')
                    ->where('role_id', 5)
                    ->where('status', 'active')
                    ->first();

                if ($defaultDoctor) {
                    DB::table('appointments')
                        ->where('id', $appointment->id)
                        ->update(['doctor_id' => $defaultDoctor->id]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
