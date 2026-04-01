<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddInprogressAndScheduledToAppointmentsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify enum to include in_progress and scheduled
        DB::statement("ALTER TABLE `appointments` MODIFY `status` ENUM('pending','in_progress','scheduled','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending'");

        // Convert existing pending appointments to in_progress to match new flow
        DB::table('appointments')->where('status', 'pending')->update(['status' => 'in_progress']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert statuses back: scheduled/in_progress -> pending
        DB::table('appointments')->whereIn('status', ['in_progress','scheduled'])->update(['status' => 'pending']);

        DB::statement("ALTER TABLE `appointments` MODIFY `status` ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }
}
