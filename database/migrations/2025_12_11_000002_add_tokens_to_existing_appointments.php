<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTokensToExistingAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Assign a random token to all appointments missing one
        DB::table('appointments')
            ->whereNull('token')
            ->orWhere('token', '')
            ->update(['token' => DB::raw('SUBSTRING(MD5(RAND()), 1, 24)')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you could clear tokens, but usually not needed
    }
}
