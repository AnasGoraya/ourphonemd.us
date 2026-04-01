<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDoctorNote extends Notification
{
    use Queueable;

    protected $note;

    public function __construct($note)
    {
        $this->note = $note;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'note',
            'note_id' => $this->note->id,
            'doctor_name' => $this->note->doctor ? $this->note->doctor->name : 'Doctor',
            'summary' => 'You have a new ' . $this->note->type . ' note.',
            'created_at' => now(),
        ];
    }
}
