<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->string('room_name')->unique(); // Unique room identifier
            $table->string('provider_room_id')->nullable(); // ID from provider (Daily.co/Agora)
            $table->enum('status', ['initiated', 'ringing', 'in_progress', 'completed', 'declined', 'missed', 'failed'])->default('initiated');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->string('disconnect_reason')->nullable();
            $table->json('meta_data')->nullable(); // For storing any extra provider info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_consultations');
    }
}
