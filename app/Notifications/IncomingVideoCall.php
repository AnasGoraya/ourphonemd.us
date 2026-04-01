<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncomingVideoCall extends Notification
{
    use Queueable;

    protected $consultation;

    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $meta = json_decode($this->consultation->meta_data, true);
        return [
            'type' => 'video_call',
            'consultation_id' => $this->consultation->id,
            'doctor_name' => $this->consultation->doctor ? $this->consultation->doctor->name : 'Doctor',
            'room_url' => $meta['url'] ?? '#',
            'summary' => 'Incoming video call from ' . ($this->consultation->doctor ? $this->consultation->doctor->name : 'Doctor'),
            'created_at' => now(),
        ];
    }
}
