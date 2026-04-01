<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'stripe_charge_id',
        'stripe_token',
        'amount',
        'currency',
        'status',
        'description',
        'card_details',
        'stripe_response',
        'processed_at',
    ];

    protected $casts = [
        'card_details' => 'array',
        'stripe_response' => 'array',
        'processed_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the patient that owns the payment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the appointment associated with the payment.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Scope for successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'succeeded');
    }

    /**
     * Scope for failed payments
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
