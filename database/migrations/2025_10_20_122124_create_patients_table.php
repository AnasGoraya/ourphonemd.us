<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->integer('age');
            $table->string('contact_number');
            $table->string('cnic')->unique();
            $table->string('password');
            $table->rememberToken(); // ✅ ADD THIS LINE
            $table->string('city');
            $table->string('verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
