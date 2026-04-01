<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->string('stripe_charge_id')->unique();
            $table->string('stripe_token')->nullable();
            $table->decimal('amount', 10, 2); // Amount in dollars
            $table->string('currency', 3)->default('usd');
            $table->string('status'); // succeeded, failed, pending, etc.
            $table->string('description')->nullable();
            $table->json('card_details')->nullable(); // Store masked card info
            $table->json('stripe_response')->nullable(); // Full Stripe response
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
            $table->index(['patient_id', 'status']);
            $table->index('stripe_charge_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
