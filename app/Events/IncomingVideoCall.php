<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncomingVideoCall implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $consultation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('patient.' . $this->consultation->patient_id);
    }
    
    public function broadcastAs()
    {
        return 'incoming.call';
    }
}
