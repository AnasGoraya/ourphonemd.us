<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingWizardColumnsToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'wizard_step1_data')) {
                $table->text('wizard_step1_data')->nullable()->after('appointment_mode');
            }
            if (!Schema::hasColumn('appointments', 'wizard_step3_data')) {
                $table->text('wizard_step3_data')->nullable()->after('wizard_step2_data');
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['wizard_step1_data', 'wizard_step3_data']);
        });
    }
}
