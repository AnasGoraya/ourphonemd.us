<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToPatientsTable extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add new fields only if they don't exist
            if (!Schema::hasColumn('patients', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('email');
            }

            if (!Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('gender');
            }

            if (!Schema::hasColumn('patients', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('contact_number');
            }

            if (!Schema::hasColumn('patients', 'address')) {
                $table->text('address')->nullable()->after('city');
            }

            if (!Schema::hasColumn('patients', 'state')) {
                $table->string('state')->nullable()->after('address');
            }

            if (!Schema::hasColumn('patients', 'zip_code')) {
                $table->string('zip_code')->nullable()->after('state');
            }

            if (!Schema::hasColumn('patients', 'blood_group')) {
                $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable()->after('zip_code');
            }

            if (!Schema::hasColumn('patients', 'marital_status')) {
                $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->after('blood_group');
            }

            if (!Schema::hasColumn('patients', 'medical_history')) {
                $table->text('medical_history')->nullable()->after('marital_status');
            }

            if (!Schema::hasColumn('patients', 'verification_token')) {
                $table->string('verification_token')->nullable()->after('password');
            }

            if (!Schema::hasColumn('patients', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('verification_token');
            }
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Remove only the columns we added
            $columns = [
                'gender', 'date_of_birth', 'emergency_contact', 'address',
                'state', 'zip_code', 'blood_group', 'marital_status',
                'medical_history', 'verification_token', 'email_verified_at'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('patients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
