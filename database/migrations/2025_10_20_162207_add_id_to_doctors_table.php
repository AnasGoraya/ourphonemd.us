<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToDoctorsTable extends Migration
{
    public function up()
    {
        // Pehle existing table ko drop karein agar woh theek nahi hai
        Schema::dropIfExists('doctors');

        // Phir nayi table create karein
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialization');
            $table->string('qualification');
            $table->integer('experience_years');
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
