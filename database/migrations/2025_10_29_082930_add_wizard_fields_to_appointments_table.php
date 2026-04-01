<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWizardFieldsToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('appointment_type')->nullable()->after('appointment_time');
            $table->string('appointment_mode')->nullable()->after('appointment_type');
            $table->text('reason')->nullable()->after('appointment_mode');
            $table->text('medications')->nullable()->after('symptoms');
            $table->string('allergies')->nullable()->after('medications');
            $table->string('work_notes')->nullable()->after('allergies');
            $table->string('alt_phone')->nullable()->after('work_notes');
            $table->json('images')->nullable()->after('alt_phone');
            $table->string('medical_history')->nullable()->after('images');
            $table->text('notes')->nullable()->after('medical_history');
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
            $table->dropColumn([
                'appointment_type',
                'appointment_mode',
                'reason',
                'medications',
                'allergies',
                'work_notes',
                'alt_phone',
                'images',
                'medical_history',
                'notes'
            ]);
        });
    }
}
