<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPatientsTable extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('password');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('profile_picture');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('emergency_contact')->nullable()->after('contact_number');
            $table->text('address')->nullable()->after('city');
            $table->string('state')->nullable()->after('address');
            $table->string('zip_code')->nullable()->after('state');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable()->after('zip_code');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->after('blood_group');
            $table->text('medical_history')->nullable()->after('marital_status');
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'date_of_birth',
                'emergency_contact',
                'address',
                'state',
                'zip_code',
                'blood_group',
                'marital_status',
                'medical_history'
            ]);
        });
    }
}
