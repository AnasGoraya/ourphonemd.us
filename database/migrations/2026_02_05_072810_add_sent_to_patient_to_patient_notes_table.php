<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentToPatientToPatientNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_notes', function (Blueprint $table) {
            $table->boolean('is_visible_to_patient')->default(false);
            $table->timestamp('sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_notes', function (Blueprint $table) {
            $table->dropColumn(['is_visible_to_patient', 'sent_at']);
        });
    }
}
