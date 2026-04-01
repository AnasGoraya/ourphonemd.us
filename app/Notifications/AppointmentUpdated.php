<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentUpdated extends Notification
{
    use Queueable;

    protected $appointment;
    protected $status;

    public function __construct($appointment, $status)
    {
        $this->appointment = $appointment;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'appointment',
            'appointment_id' => $this->appointment->id,
            'status' => $this->status,
            'date' => $this->appointment->appointment_date,
            'summary' => 'Your appointment status has been updated to ' . ucfirst($this->status) . '.',
            'created_at' => now(),
        ];
    }
}
