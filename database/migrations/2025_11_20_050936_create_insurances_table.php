<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');

            // Required Insurance Fields
            $table->string('insurance_type');
            $table->string('policy_number');
            $table->string('member_name');
            $table->string('insurance_provider');
            $table->string('insurance_id');
            $table->string('relationship');

            // Optional Insurance Fields
            $table->string('group_number')->nullable();
            $table->string('edi_payer')->nullable();
            $table->string('coverage_type')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->boolean('is_primary')->default(false);

            // Subscriber Information
            $table->string('subscriber_name')->nullable();
            $table->string('subscriber_copay')->nullable();
            $table->string('subscriber_ssn')->nullable();
            $table->date('subscriber_date_of_birth')->nullable();
            $table->text('subscriber_address')->nullable();

            // Card Images
            $table->string('card_front_image')->nullable();
            $table->string('card_back_image')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
